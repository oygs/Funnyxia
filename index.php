<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>爆笑图库</title>
    <style>
        /* 通用样式 */
        body {
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: sans-serif;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* 拟态风格样式 */
        .button {
            display: inline-block;
            background-color: #f9f9f9;
            border: none;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            color: #333;
            cursor: pointer;
            font-size: 16px;
            padding: 12px 24px;
            margin: 8px;
            transition: all 0.2s;
        }

        .button:hover {
            background-color: #eee;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* 黑暗模式样式 */
        .dark-mode {
            background-color: #111;
            color: #fff;
        }

        .button.dark-mode {
            background-color: #333;
            color: #fff;
        }

        .fas {
            font-size: 24px;
        }

        .fa-sun {
            display: none;
        }

        .dark-mode .fa-moon {
            display: none;
        }

        .dark-mode .fa-sun {
            display: inline-block;
        }

        /* 放置在右下角 */
        .bottom-right {
            position: fixed;
            bottom: 0;
            right: 0;
            margin: 16px;
            z-index: 9999;
        }

        /* 新增的样式 */
        img {
            max-width: 100%;
            max-height: 60vh;
            object-fit: contain;
        }
        #refresh-btn {
            font-size: 14px;
            padding: 8px 16px;
        }
    </style>
    <!-- 引入 Font Awesome CSS 文件 -->
    <link rel="stylesheet" href="https://lf6-cdn-tos.bytecdntp.com/cdn/expire-1-M/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        <?php
        session_start(); // 开启 session

        $imageUrls = file('images.txt', FILE_IGNORE_NEW_LINES); // 读取图片链接
        $excludedIndexes = isset($_SESSION['excluded_indexes']) ? $_SESSION['excluded_indexes'] : array(); // 获取已经选择过的图片序号
        $availableIndexes = array_diff(range(0, count($imageUrls) - 1), $excludedIndexes); // 排除已经选择过的图片序号，得到可用的图片序号
        if (empty($availableIndexes)) { // 如果没有可用的图片序号了，则重新开始选择
            $availableIndexes = range(0, count($imageUrls) - 1);
            $_SESSION['excluded_indexes'] = array(); // 重置已经选择的图片序号
        }
        $randomIndex = array_rand($availableIndexes); // 从可用的图片序号中随机选择一个序号
        $imageUrl = $imageUrls[$availableIndexes[$randomIndex]]; // 根据序号获取图片链接
        $_SESSION['excluded_indexes'][] = $availableIndexes[$randomIndex]; // 将已经选择的图片序号加入排除列表
        ?>

        <img src="<?php echo $imageUrl; ?>" alt="随机图片">
        <button class="button" id="refresh-btn">
            <i class="fas fa-sync-alt"></i>
            换一张
        </button>
    </div>

    <!-- 将切换模式按钮放在右下角 -->
    <div class="bottom-right">
        <button class="button switch-mode" onclick="toggleDarkMode()">
            <i class="fas fa-sun"></i>
            <i class="fas fa-moon"></i>
        </button>
    </div>

    <script>
        // 切换黑暗模式
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            var dark_mode = document.body.classList.contains('dark-mode');
            localStorage.setItem('dark_mode', dark_mode); // 使用 localStorage 来保存黑暗模式状态
        }

        // 获取 localStorage 中的黑暗模式状态
        function getDarkModeLocalStorage() {
            return (localStorage.getItem('dark_mode') === 'true');
        }

        // 页面加载时根据 localStorage 设置黑暗模式状态
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.toggle('dark-mode', getDarkModeLocalStorage());
        });
    </script>
    <!-- 引入 Font Awesome JS 文件 -->
    <script src="https://lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="app.js"></script>
</body>
</html>