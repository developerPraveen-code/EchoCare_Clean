<?php

// USER STORY #37: View FRA Category
// USER STORY #38: Update FRA Category
// USER STORY #39: Suspend FRA Category
// USER STORY #40: Search FRA Category
// USER STORY #48: Create FRA Category
// BCE Role: Entity

class FRACategory
{
    public function initialiseData(): void
    {
        if (!isset($_SESSION['fra_category_list'])) {
            $_SESSION['fra_category_list'] = [
                [
                    'categoryId' => 1,
                    'categoryName' => 'Education',
                    'description' => 'Fundraising activities for school and learning support.',
                    'status' => 'Active'
                ],
                [
                    'categoryId' => 2,
                    'categoryName' => 'Food Support',
                    'description' => 'Fundraising activities for meals and food aid.',
                    'status' => 'Active'
                ],
                [
                    'categoryId' => 3,
                    'categoryName' => 'Healthcare',
                    'description' => 'Fundraising activities for medical needs.',
                    'status' => 'Active'
                ]
            ];
        }
    }

    // USER STORY #37: View FRA Category
    public function getAllCategories(): array
    {
        $this->initialiseData();
        return $_SESSION['fra_category_list'];
    }

    // USER STORY #37 / #38: Get one FRA Category
    public function getCategory(int $categoryId): ?array
    {
        $this->initialiseData();

        foreach ($_SESSION['fra_category_list'] as $category) {
            if ($category['categoryId'] === $categoryId) {
                return $category;
            }
        }

        return null;
    }

    // USER STORY #48: Create FRA Category
    public function createCategory(string $categoryName, string $description): string
    {
        $this->initialiseData();

        $newId = empty($_SESSION['fra_category_list'])
            ? 1
            : max(array_column($_SESSION['fra_category_list'], 'categoryId')) + 1;

        $_SESSION['fra_category_list'][] = [
            'categoryId' => $newId,
            'categoryName' => $categoryName,
            'description' => $description,
            'status' => 'Active'
        ];

        return 'FRA category created successfully.';
    }

    // USER STORY #38: Update FRA Category
    public function updateCategory(int $categoryId, string $categoryName, string $description): string
    {
        $this->initialiseData();

        foreach ($_SESSION['fra_category_list'] as &$category) {
            if ($category['categoryId'] === $categoryId) {
                $category['categoryName'] = $categoryName;
                $category['description'] = $description;

                return 'FRA category updated successfully.';
            }
        }

        return 'FRA category update failed.';
    }

    // USER STORY #39: Suspend FRA Category
    public function suspendCategory(int $categoryId): string
    {
        $this->initialiseData();

        foreach ($_SESSION['fra_category_list'] as &$category) {
            if ($category['categoryId'] === $categoryId) {
                $category['status'] = 'Suspended';

                return 'FRA category suspended successfully.';
            }
        }

        return 'FRA category suspension failed.';
    }

    // USER STORY #40: Search FRA Category
    public function searchCategory(string $searchTerm): array
    {
        $this->initialiseData();

        return array_values(array_filter($_SESSION['fra_category_list'], function ($category) use ($searchTerm) {
            return $searchTerm === '' ||
                stripos($category['categoryName'], $searchTerm) !== false ||
                stripos($category['description'], $searchTerm) !== false ||
                stripos($category['status'], $searchTerm) !== false;
        }));
    }
}