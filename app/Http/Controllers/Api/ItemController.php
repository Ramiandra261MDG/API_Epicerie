<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use function Laravel\Prompts\search;

class ItemController extends Controller
{
    //
    public function get()
    {
        $itemsAll = Item::orderBy('name', 'asc')->paginate(10);

        if ($itemsAll) {
            return response()->json([
                "status" => true,
                "message" => "Items loaded successfully",
                "items" => $itemsAll
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "No items loaded",
        ]);
    }

    //
    public function store(Request $request)
    {
        // Data validation
        $request->validate([
            "name" => "required",
            "price" => "required",
        ]);

        // Data save
        Item::create([
            "name" => $request->name,
            "price" => $request->price,
            "total" => $request->total,
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "Item created successfully"
        ]);
    }

    //
    public function search(int $id)
    {
        $itemToSearch = Item::Find($id);

        return $itemToSearch;
    }

    //
    public function update(Request $request, int $id)
    {
        $itemToEdit = $this->search($id);

        // Data validation
        // $request->validate([
        //     "name" => "required",
        //     "price" => "required",
        //     "total" => "required",
        // ]);

        // Get total item
        $total = Item::find($request->id)->total;

        // Data update
        $itemToEdit->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'total' => $total + $request->input('total'),
        ]);

        return response()->json([
            "status" => true,
            "message" => "Item updated successfully",
            "itemUpdated" => $itemToEdit
        ]);
    }

    //
    public function delete(int $id)
    {
        $itemToDelete = Item::find($id);

        if (!$itemToDelete) {
            return response()->json([
                "status" => false,
                "message" => "Item not found",
            ], 404);
        }

        $itemToDelete->delete();

        return response()->json([
            "status" => true,
            "message" => "Item deleted successfully",
        ]);
    }
}
