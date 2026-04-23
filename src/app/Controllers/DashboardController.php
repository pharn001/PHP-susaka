<?php

class DashboardController extends Controller {
    public function index(): void {
        $user = AuthService::user();

        $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'activePage' => 'dashboard',
            'user' => $user,
            'isAdmin' => AuthService::isAdmin(),
        ]);
    }
}
