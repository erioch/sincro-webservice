<?php

namespace App\Application\Service\Sincro;

use App\Entity\Sincro;

class PostSincroService extends SincroService
{
    /**
     * @param PostSincroRequest $request
     *
     * @return Sincro
     */
    public function execute($request = null)
    {
        $origin = $request->origin();
        $destiny = $request->destiny();
        $file = $request->uploadedFile();

        // Generate a unique name for the file before saving it
        $filename = md5(uniqid()).'.'.$file->guessExtension();

        // Move the file to the directory where brochures are stored
        $file->move($this->sincroUploadsDir, $filename);

        $sincro = Sincro::makePost(
            $origin,
            $destiny,
            $filename
        );

        $this->sincroRepository->add($sincro);

        return $sincro;
    }
}
