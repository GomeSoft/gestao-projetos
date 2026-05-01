<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Exception;

class FileUploaderService
{
    // Mapeamento de Magic Bytes (Assinaturas Binárias)
    private const ALLOWED_TYPES = [
        'ffd8ffe0' => 'image/jpeg',
        'ffd8ffe1' => 'image/jpeg',
        '89504e47' => 'image/png',
        '47494638' => 'image/gif',
    ];

    public function uploadValidado(UploadedFile $file, string $folder)
    {
        // 1. Validar Magic Bytes (Independente da extensão do frontend)
        $path = $file->getPathname();
        $handle = fopen($path, 'rb');
        $header = fread($handle, 4); // Lemos os primeiros 4 bytes
        fclose($handle);
        
        $signature = bin2hex($header);

        if (!isset(self::ALLOWED_TYPES[$signature])) {
            throw new Exception("Segurança: O ficheiro não corresponde à assinatura visual real.");
        }

        // 2. Gerar nome aleatório para evitar Path Traversal
        $safeName = bin2hex(random_bytes(16)) . '.' . $file->getClientOriginalExtension();

        // 3. Guardar no disco 'private' (não acessível diretamente por URL)
        return $file->storeAs($folder, $safeName, 'private');
    }
}