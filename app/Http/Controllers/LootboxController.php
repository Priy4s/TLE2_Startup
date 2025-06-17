<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class LootboxController extends Controller
{
    public function open()
    {
        $user = Auth::user();

        // Pas dit aan om meer items toe te voegen
        $items = ['Hat', 'Blue Color', 'Pants', 'Glasses'];
        $randomItemName = $items[array_rand($items)];
        $item = Item::firstOrCreate(['name' => $randomItemName]);

        // Koppel aan user (voorkom dubbele)
        $user->items()->syncWithoutDetaching([$item->id]);

        return response()->json([
            'message' => 'You received: ' . $randomItemName,
            'item' => $randomItemName
        ]);
    }
}

