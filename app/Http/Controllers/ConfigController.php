<?php

namespace App\Http\Controllers;

use App\Config;
use App\Http\Requests\ConfigRequest;
use App\Http\Resources\ConfigResource;

class ConfigController extends Controller
{
    public function edit(Config $config)
    {
        return request()->ajax() ?
            response()
                ->json(['data' => new ConfigResource($config), 'message' => __('Edit Data')]) :
            view('configs.edit', compact('config'));
    }

    public function update(ConfigRequest $request, Config $config)
    {
        $data = $request->all();
        if (!isset($data['is_open']) || empty($data['is_open'])) {
            $data['is_open'] = 0;
        }

        $data['shipping_tax'] = Config::removeMaskMoney($data['shipping_tax']);
        if ($request->hasFile('image')) {
            $request->file('image')
                ->storeAs(Config::getFilePath(), $config->image);
        }

        $config->update($data);
        $message = __('Entity updated successfully.');
        return request()->ajax() ?
            response()
                ->json(['data' => new ConfigResource($config), 'message' => $message]) :
            redirect()
                ->route('configs.edit', $config)
                ->with('status', $message);
    }
}
