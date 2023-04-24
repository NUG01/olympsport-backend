<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteAssetRequest;
use App\Http\Resources\Admin\WebsiteAssetResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebsiteAssetController extends Controller
{
    public function termsAndConditions(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return WebsiteAssetResource::collection(DB::table('website_assets')->where('id', 1)->get());
    }

    public function aboutUs(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return WebsiteAssetResource::collection(DB::table('website_assets')->where('id', 2)->get());
    }

    public function update($id, WebsiteAssetRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        DB::table('website_assets')->where('id', $id)->update($request->validated());

        return WebsiteAssetResource::collection(DB::table('website_assets')->where('id', $id)->get());
    }
}
