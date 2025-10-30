<?php

namespace App\Services\PacketHandler;

use Illuminate\Http\Request;

final class Package
{
    public function __construct(private readonly Request $request) {}

    public function presentation()
    {
        // Pull the "package"
        $pkg = (array) $this->request->input('package', []);

        // Try to find existing video, otherwise create a new one
        $pkgId = data_get($pkg, 'pkg_id');
        $pkg = \App\Models\Package::firstOrNew(['id' => $pkgId]);

        // Build attributes
        $pkg->fill([
            'id'          => $pkgId,
            'presentation'    => json_encode($this->request->all(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
        ]);

        $pkg->save();
    }
}
