<?php

namespace App\Repositories\Interfaces;

Interface BlogRepositoryInterface{
    public function fetchService();
    public function store($request);
    public function destroy($blog);
    public function show($slug);
    public function updateService($request, $blog);
}