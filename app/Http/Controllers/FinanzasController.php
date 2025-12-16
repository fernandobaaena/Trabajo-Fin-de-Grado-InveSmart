<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Movimiento;

class FinanzasController extends Controller
{

    
    public function index()
    {
        $userId = Auth::id();
        $movimientos = Movimiento::where('user_id', $userId)->orderBy('fecha','desc')->get();

        $ingresos = $movimientos->where('tipo','ingreso')->sum('cantidad');
        $gastos   = $movimientos->where('tipo','gasto')->sum('cantidad');
        $ahorros  = $ingresos - $gastos;

        return view('finanzas.index', compact('movimientos','ingresos','gastos','ahorros'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:ingreso,gasto',
            'cantidad' => 'required|numeric|min:0',
            'fecha' => 'required|date',
        ]);

        Movimiento::create([
            'user_id' => Auth::id(),
            'tipo' => $request->tipo,
            'cantidad' => $request->cantidad,
            'fecha' => $request->fecha
        ]);

        return redirect()->back()->with('success','Movimiento guardado correctamente');
    }

    public function destroy($id)
    {
        $mov = Movimiento::where('id',$id)->where('user_id',Auth::id())->firstOrFail();
        $mov->delete();

        return redirect()->back()->with('success','Movimiento eliminado correctamente');
    }
    public function edit($id)
{
    $movimiento = Movimiento::where('user_id', Auth::id())->findOrFail($id);
    $movimientos = Movimiento::where('user_id', Auth::id())->orderBy('fecha')->get();

    $ingresos = $movimientos->where('tipo','ingreso')->sum('cantidad');
    $gastos   = $movimientos->where('tipo','gasto')->sum('cantidad');
    $ahorros  = $ingresos - $gastos;

    return view('finanzas.index', compact('movimientos','ingresos','gastos','ahorros','movimiento'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'tipo' => 'required|in:ingreso,gasto',
        'cantidad' => 'required|numeric|min:0',
        'fecha' => 'required|date',
    ]);

    $mov = Movimiento::where('user_id', Auth::id())->findOrFail($id);
    $mov->update([
        'tipo' => $request->tipo,
        'cantidad' => $request->cantidad,
        'fecha' => $request->fecha
    ]);

    return redirect()->route('finanzas.index')->with('success','Movimiento actualizado correctamente');
}

}
