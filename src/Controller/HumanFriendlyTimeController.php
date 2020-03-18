<?php

namespace App\Controller;

use App\Service\TimeTransformerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * @Route("/api/human-friendly-time")
 */
class HumanFriendlyTimeController extends AbstractController
{
    /**
     * @Route("", name="retrieve_human_friendly_time")
     */
    public function retrieve(Request $request, TimeTransformerInterface $timeTransformer)
    {
        $time = $request->query->get('time', null);

        // Validation of $time is handled in the service.
        $humanFriendlyTime = $timeTransformer->getTime($time);

        if (!$humanFriendlyTime) {
            return $this->json([
                'error' => 'Unable to create a human friendly time from: ' . $time
            ], 422);
        }

        return $this->json([
            'human-friendly-time' => $humanFriendlyTime
        ], 200);
    }
}
