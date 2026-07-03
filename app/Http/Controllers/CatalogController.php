<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class CatalogController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show main_datas_catalogs'), only: ['index','show']),
            new Middleware(PermissionMiddleware::using('show main_datas_catalogs'), except: ['create','store','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('create catalog'), only: ['create','store']),
            new Middleware(PermissionMiddleware::using('create catalog'), except: ['index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit catalog'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('edit catalog'), except: ['index','show','create','store','destroy']),
            new Middleware(PermissionMiddleware::using('delete catalog'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('delete catalog'), except: ['index','create','store','edit','update']),
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Catalog/catalogs', [
            'Catalogs' => Catalog::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Catalog/createcatalog');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'catalog_name' => 'required|unique:catalogs'
        ]);
        Catalog::create($validated);

        return redirect("/catalogs")->with("success", "Successfull created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function show(Catalog $catalog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function edit(Catalog $catalog)
    {
        $editCatalog = Catalog::findOrFail($catalog->catalog_id);

        return view('Catalog/editCatalog', compact('editCatalog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catalog $catalog)
    {
        $validated = $request->validate([
            'catalog_name' => 'required|unique:catalogs'
        ]);

        Catalog::where('catalog_id', $catalog->catalog_id)->update($validated);
        
        return redirect("/catalogs")->with("success", "Successfull updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalog $catalog)
    {
        $deleteCatalog = Catalog::findOrFail($catalog->catalog_id);
        $deleteCatalog->delete();
        
        return redirect("/catalogs")->with("success", "Successfull deleted!");
    }
}
