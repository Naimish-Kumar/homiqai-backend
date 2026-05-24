<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RoomDesign;
use App\Models\Moodboard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    public function home(): View
    {
        return view('welcome');
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function showDeleteAccount(): View
    {
        return view('pages.delete-account');
    }

    public function deleteAccount(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'confirmation' => ['required', 'string', 'in:DELETE'],
        ]);

        $user = User::query()->where('email', $validated['email'])->first();

        if ($user) {
            DB::transaction(function () use ($user): void {
                $user->roomDesigns()->with('furnitureRecommendations')->get()->each(function ($design): void {
                    if ($design->original_image_path) {
                        Storage::disk('public')->delete($design->original_image_path);
                    }

                    if ($design->generated_image_path) {
                        Storage::disk('public')->delete($design->generated_image_path);
                    }

                    $design->furnitureRecommendations()->delete();
                    $design->delete();
                });

                $user->subscriptions()->delete();
                $user->tokens()->delete();
                $user->delete();
            });
        }

        return redirect()
            ->route('delete-account')
            ->with('status', 'Your Homiq account and related design data have been deleted successfully.');
    }

    public function sharedDesign(string $hash): View
    {
        $decoded = base64_decode(urldecode($hash));
        if (!$decoded || strpos($decoded, ':') === false) {
            abort(404);
        }

        [$id, $signature] = explode(':', $decoded, 2);

        if (!hash_equals(hash_hmac('sha256', $id, config('app.key')), $signature)) {
            abort(403, 'Invalid signature.');
        }

        $design = RoomDesign::with(['style', 'furnitureRecommendations', 'user'])->findOrFail($id);

        $disk = Storage::disk('public');
        $useSignedUrls = config('filesystems.default') === 's3';

        $originalUrl = $design->original_image_path
            ? ($useSignedUrls ? $disk->temporaryUrl($design->original_image_path, now()->addHours(2)) : $disk->url($design->original_image_path))
            : null;

        $generatedUrl = $design->generated_image_path
            ? ($useSignedUrls ? $disk->temporaryUrl($design->generated_image_path, now()->addHours(2)) : $disk->url($design->generated_image_path))
            : null;

        return view('pages.shared-design', compact('design', 'originalUrl', 'generatedUrl'));
    }

    public function sharedMoodboard(string $hash): View
    {
        $decoded = base64_decode(urldecode($hash));
        if (!$decoded || strpos($decoded, ':') === false) {
            abort(404);
        }

        [$id, $signature] = explode(':', $decoded, 2);

        if (!hash_equals(hash_hmac('sha256', $id, config('app.key')), $signature)) {
            abort(403, 'Invalid signature.');
        }

        $moodboard = Moodboard::with(['style', 'user'])->findOrFail($id);

        return view('pages.shared-moodboard', compact('moodboard'));
    }
}
