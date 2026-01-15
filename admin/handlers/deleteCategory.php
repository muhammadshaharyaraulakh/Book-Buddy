<?php
require __DIR__ . '/../../config/config.php';

header('Content-Type: application/json');

$response = [
    "status" => "error",
    "message" => "Failed to delete category.",
    "field" => "general"
];

try {
    $category_id = $_POST['id'] ?? null;

    if (empty($category_id) || !filter_var($category_id, FILTER_VALIDATE_INT)) {
        throw new Exception("Invalid Category ID.");
    }

    // Fetch all posts for this category
    $AllPosts = $connection->prepare("SELECT coverImage FROM book WHERE category_id = :id");
    $AllPosts->execute([':id' => $category_id]);
    $posts = $AllPosts->fetchAll(PDO::FETCH_OBJ);

    $images_dir = realpath(__DIR__ . "/../../images/");

    foreach ($posts as $post) {
        if (!empty($post->coverImage)) {
            $image_path = realpath($images_dir . "/" . $post->coverImage);
            if ($image_path && str_starts_with($image_path, $images_dir) && file_exists($image_path)) {
                unlink($image_path);
            }
        }
    }

    // Delete posts
    $deletePosts = $connection->prepare("DELETE FROM book WHERE category_id = :id");
    $deletePosts->execute([':id' => $category_id]);

    // Delete category
    $deleteCategory = $connection->prepare("DELETE FROM categories WHERE id = :id");
    $deleteCategory->execute([':id' => $category_id]);

    if ($deleteCategory->rowCount() === 0) {
        throw new Exception("Category not found or already deleted.");
    }

    $response = [
        "status" => "success",
        "message" => "Category and related posts deleted successfully!"
    ];

} catch (Exception $e) {
    http_response_code(400);
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
exit;
