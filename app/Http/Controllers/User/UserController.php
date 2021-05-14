<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Foundation\Application;

class UserController extends Controller
{
    /**
    * UserController constructor.
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * @param Request $request
    * @return Application|Factory|View
    */
    public function _viewUserLogin(Request $request): Application|Factory|View|RedirectResponse
    {
        $this->vs->setTitle('Login');

        return Auth::check()
            ? redirect('dashboard')
            : view('user.view_user_login');
    }

    /**
    * @param Request $request
    * @return RedirectResponse
    * @throws ValidationException
    */
    public function _submitUserLogin(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        return Auth::attempt($request->only('username', 'password'))
            ? redirect()->route('dashboard')
            : back()->withInput();
    }

    /**
    * @param Request $request
    * @return RedirectResponse
    */
    public function _viewUserLogout(Request $request): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
    * @param Request $request
    * @return Application|Factory|View
    */
    public function _viewUserDashboard(Request $request): Application|Factory|View
    {
        $user = Auth::user();
        $user->load('feeds', 'feeds.feed_view_log');

        $this->vs->setTitle('Dashboard');

        // here we are going to just acquire some random data regarding reporting... it's not really relevant but
        // might as well make the page a little prettier.
        $total_posts      = 0;
        $total_posts_read = 0;
        foreach ($user->feeds as $feed) {
            [$feed_posts_read, $feed_posts] = explode('/', $feed->getPostsRead());
            $total_posts += $feed_posts;
            $total_posts_read += $feed_posts_read;
        }

        return view('user.view_user_dashboard', compact(
            'user',
            'total_posts',
            'total_posts_read'
        ));
    }

    /**
    * @param Request $request
    * @return Application|Factory|View|RedirectResponse
    */
    public function _viewUserRegister(Request $request): Application|Factory|View|RedirectResponse
    {
        $this->vs->setTitle('Register');

        return Auth::check()
            ? redirect()->route('dashboard')
            : view('user.view_user_register');
    }

    /**
    * @param Request $request
    * @return RedirectResponse
    * @throws ValidationException
    */
    public function _submitUserRegister(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'email'    => 'required|unique:user',
            'username' => 'required|unique:user',
            'password' => 'required'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');
        $email = $request->input('email');

        User::create([
            'username' => $username,
            'password' => Hash::make($password),
            'email'    => $email
        ]);

        return redirect()->route('login');
    }
}
