<?php

class FundraisingActivity
{
    public function initialiseData(): void
    {
        if (!isset($_SESSION['fra_list'])) {
            $_SESSION['fra_list'] = [];
        }
    }

    public function createFRA(int $fundraiserId, string $title, string $description, float $goalAmount, string $category): string
    {
        $this->initialiseData();

        $newId = empty($_SESSION['fra_list'])
            ? 1
            : max(array_column($_SESSION['fra_list'], 'fraId')) + 1;

        $_SESSION['fra_list'][] = [
            'fraId' => $newId,
            'fundraiserId' => $fundraiserId,
            'title' => $title,
            'description' => $description,
            'goalAmount' => $goalAmount,
            'amountRaised' => 0,
            'category' => $category,
            'status' => 'Active',
            'startDate' => date('Y-m-d'),
            'endDate' => date('Y-m-d', strtotime('+30 days')),
            'views' => 0,
            'shortlistCount' => 0
        ];

        return 'FRA created successfully.';
    }

    public function getFRAList(int $fundraiserId): array
    {
        $this->initialiseData();

        return array_values(array_filter($_SESSION['fra_list'], fn($fra) =>
            $fra['fundraiserId'] === $fundraiserId
        ));
    }

    public function getAllFRA(): array
    {
        $this->initialiseData();

        return array_values(array_filter($_SESSION['fra_list'], fn($fra) =>
            $fra['status'] === 'Active'
        ));
    }

    public function getFRA(int $fraId): ?array
    {
        $this->initialiseData();

        foreach ($_SESSION['fra_list'] as &$fra) {
            if ($fra['fraId'] === $fraId) {
                $fra['views']++;
                return $fra;
            }
        }

        return null;
    }

    public function updateFRA(int $fraId, string $title, string $description, float $goalAmount, string $status): ?array
    {
        $this->initialiseData();

        foreach ($_SESSION['fra_list'] as &$fra) {
            if ($fra['fraId'] === $fraId) {
                $fra['title'] = $title;
                $fra['description'] = $description;
                $fra['goalAmount'] = $goalAmount;
                $fra['status'] = $status;
                return $fra;
            }
        }

        return null;
    }

    public function disableFRA(int $fraId): ?array
    {
        $this->initialiseData();

        foreach ($_SESSION['fra_list'] as &$fra) {
            if ($fra['fraId'] === $fraId) {
                $fra['status'] = 'Disabled';
                return $fra;
            }
        }

        return null;
    }

    public function searchMyFRA(int $fundraiserId, string $keyword): array
    {
        $this->initialiseData();

        return array_values(array_filter($_SESSION['fra_list'], fn($fra) =>
            $fra['fundraiserId'] === $fundraiserId &&
            (
                $keyword === '' ||
                stripos($fra['title'], $keyword) !== false ||
                stripos($fra['description'], $keyword) !== false ||
                stripos($fra['category'], $keyword) !== false
            )
        ));
    }

    public function searchAllFRA(string $keyword): array
    {
        $this->initialiseData();

        return array_values(array_filter($_SESSION['fra_list'], fn($fra) =>
            $fra['status'] === 'Active' &&
            (
                $keyword === '' ||
                stripos($fra['title'], $keyword) !== false ||
                stripos($fra['description'], $keyword) !== false ||
                stripos($fra['category'], $keyword) !== false
            )
        ));
    }

    public function viewShortlistCount(int $fraId): int
    {
        $this->initialiseData();

        foreach ($_SESSION['fra_list'] as $fra) {
            if ($fra['fraId'] === $fraId) {
                return $fra['shortlistCount'] ?? 0;
            }
        }

        return 0;
    }

    public function increaseShortlistCount(int $fraId): void
    {
        $this->initialiseData();

        foreach ($_SESSION['fra_list'] as &$fra) {
            if ($fra['fraId'] === $fraId) {
                $fra['shortlistCount'] = ($fra['shortlistCount'] ?? 0) + 1;
                return;
            }
        }
    }

    public function getCompletedFRA(int $fundraiserId): array
    {
        $this->initialiseData();

        return array_values(array_filter($_SESSION['fra_list'], fn($fra) =>
            $fra['fundraiserId'] === $fundraiserId &&
            $fra['status'] === 'Completed'
        ));
    }

    public function searchCompletedFRA(int $fundraiserId, string $keyword): array
    {
        return array_values(array_filter($this->getCompletedFRA($fundraiserId), fn($fra) =>
            $keyword === '' ||
            stripos($fra['title'], $keyword) !== false ||
            stripos($fra['description'], $keyword) !== false ||
            stripos($fra['category'], $keyword) !== false
        ));
    }
}