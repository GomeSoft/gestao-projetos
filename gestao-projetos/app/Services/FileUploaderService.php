<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Exception;

class FileUploaderService
{
    // Lista de Magic Bytes permitidos (Ex: JPG, PNG, PDF)
    private const ALLOWED_SIGNATURES = [
        'ffd8ffe0' => 'image/jpeg',
        'ffd8ffe1' => 'image/jpeg',
        '89504e47' => 'image/png',
        '25504446' => 'application/pdf',
    ];

    public function uploadSecuro(UploadedFile $file, string $folder)
    {
        // 1. Validar Magic Bytes (Leitura binária)
        $path = $file->getPathname();
        $handle = fopen($path, 'rb');
        $bytes = bin2hex(fread($handle, 4));
        fclose($handle);

        if (!isset(self::ALLOWED_SIGNATURES[$bytes])) {
            throw new Exception("Tipo de ficheiro inválido: Assinatura não reconhecida.");
        }

        // 2. Tratar trackers e metadados (Simulação de limpeza)
        // Em produção, usaríamos bibliotecas como o ExifTool para remover GPS/Trackers
        // 3. Gerar nome aleatório (Nunca usar o nome original para evitar Path Traversal)
        $fileName = bin2hex(random_bytes(16)) . '.' . $file->getClientOriginalExtension();

        // 4. Armazenar fora da pasta pública por defeito (Segurança de camadas)
        return $file->storeAs($folder, $fileName, 'private');
    }
}