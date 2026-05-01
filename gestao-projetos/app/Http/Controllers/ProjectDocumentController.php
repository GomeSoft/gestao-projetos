<?php

namespace App\Http\Controllers;

use App\Services\FileUploaderService;
use Exception;
use Illuminate\Http\Request;
class ProjectDocumentController extends Controller
{
    public function store(Request $request, FileUploaderService $uploader)
    {
        $request->validate([
            'documento' => 'required|file|max:2048',
            'project_id' => 'required|exists:projects,id'
        ]);

        try {
            $path = $uploader->uploadSecuro($request->file('documento'), 'project_docs');



            return back()->with('success', 'Ficheiro guardado com segurança.');
        } catch (Exception $e) {
            return back()->withErrors(['documento' => 'Erro de segurança no ficheiro.']);
        }
    }
}
