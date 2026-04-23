<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return back()
                ->withErrors(['email' => 'We could not verify those account credentials.'])
                ->withInput($request->except('password'));
        }

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

        return redirect()
            ->route('delete-account')
            ->with('status', 'Your Homiq account and related design data have been deleted successfully.');
    }
}
