truncate table `img/article_thumbnails`;
INSERT INTO `img/article_thumbnails` (`id`, `img`, `img/article_id`, `user_id`, `created_at`, `updated_at`)
VALUES
    (NULL, 'img/article1.jpg', '1', '1', '2023-04-18 18:24:17', NULL),
    (NULL, 'img/article4-1.jpg', '4', '3', '2023-04-17 12:24:17', '2023-04-17 12:25:17'),
    (NULL, 'img/article4-2.jpg', '4', '1', '2023-04-19 12:24:17', NULL),
    (NULL, 'img/article2-3.jpg', '4', '3', '2023-04-30 12:24:17', NULL);
