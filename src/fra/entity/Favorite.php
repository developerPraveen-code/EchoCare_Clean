<?php

require_once __DIR__ . '/FundraisingActivity.php';

class Favorite
{
    public function initialiseData(): void
    {
        if (!isset($_SESSION['favorite_list'])) {
            $_SESSION['favorite_list'] = [];
        }
    }

    public function saveFavorite(int $userId, int $fraId): bool
    {
        $this->initialiseData();

        foreach ($_SESSION['favorite_list'] as $favorite) {
            if ($favorite['userId'] === $userId && $favorite['fraId'] === $fraId) {
                return false;
            }
        }

        $_SESSION['favorite_list'][] = [
            'favoriteId' => count($_SESSION['favorite_list']) + 1,
            'userId' => $userId,
            'fraId' => $fraId,
            'savedDate' => date('Y-m-d')
        ];

        $fundraisingActivity = new FundraisingActivity();
        $fundraisingActivity->increaseShortlistCount($fraId);

        return true;
    }

    public function getSavedFRA(int $userId): array
    {
        $this->initialiseData();

        $fundraisingActivity = new FundraisingActivity();
        $savedFRA = [];

        foreach ($_SESSION['favorite_list'] as $favorite) {
            if ($favorite['userId'] === $userId) {
                $fra = $fundraisingActivity->getFRA($favorite['fraId']);

                if ($fra !== null) {
                    $savedFRA[] = $fra;
                }
            }
        }

        return $savedFRA;
    }

    public function searchSavedFRA(int $userId, string $keyword): array
    {
        return array_values(array_filter($this->getSavedFRA($userId), fn($fra) =>
            $keyword === '' ||
            stripos($fra['title'], $keyword) !== false ||
            stripos($fra['description'], $keyword) !== false ||
            stripos($fra['category'], $keyword) !== false
        ));
    }
}