<?php

namespace App\Interfaces;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

interface Crud
{
    /**
     * @return array
     * @return object
     */

    public function index(Request $request);
    public function create(): View;
    public function store(Request $request): RedirectResponse;
    public function edit(string $id): View;
    public function update(Request $request, string $id): RedirectResponse;
    public function show(string $id): View;
    public function destroy(string $id): RedirectResponse;
    public function restore($id): RedirectResponse;
    public function restoreAll(): RedirectResponse;
    public function forceDelete($id): RedirectResponse;
    // public function getActiveCategory(): object;
}
