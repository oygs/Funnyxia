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
    
    
    /* 悬浮岛样式 */
    
.island__content a {
  display: inline-block;
  padding: 8px 16px;
  margin: 10px;
  font-size: 14px;
  line-height: 1.5;
  text-align: center;
  color: #fff;

  border-radius: 4px; /* 设置圆角 */
}

.island__content a:hover {
  background-color: #0069d9; /* 鼠标悬停时变色 */
}
    
   .island {
    position: fixed;
    bottom: 60px; /* 预留悬浮岛高度 */
    right: 16px;
    width: 56px; /* 悬浮岛宽度 */
    height: 140px; /* 悬浮岛高度 */
    border-radius: 20px 20px 8px 8px; /* 圆角边框 */
    background-color: #fff;
    box-shadow: 0 4px 12px rgba(51, 51, 51, 0.1);
    font-size: 14px;
    overflow: hidden;
    transition: all 0.2s;
  }

  .island:hover {
    height: 240px; /* 悬浮岛展开高度 */
  }

  .island__content {
    padding: 12px 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    height: 100%;
  }

  .island__content a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    margin: 4px 0;
    border-radius: 50%;
    color: #666;
    text-decoration: none;
    transition: all 0.2s;
  }

  .island__content a:hover {
    background-color: #f5f5f5;
  }

  /* 点赞和收藏只显示一个图标，另一个占位隐藏 */
  .island__content a.like {
    background-image: url(like.svg);
  }

  .island__content a.favorite {
    background-image: url(favorite.svg);
  }

  .island__content a.like.empty,
  .island__content a.favorite.empty {
    display: none;
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

<!-- 添加悬浮岛 -->
<div class="island bottom-right">
  <div class="island__content">
    <a href="#">关于</a>
    <a href="#">分享</a>
    <a href="#">点赞</a>
    <a href="#">收藏</a>
    <a href="<?php echo $imageUrl; ?>" download="image.jpg" target="_blank">下载</a>
    <a href="#">更新</a>
  </div>
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

    // 监听键盘方向键事件
    document.addEventListener('keydown', function(e) {
      if (e.keyCode === 39 || e.keyCode === 40) { // 右/下方向键
        document.getElementById('refresh-btn').click(); // 触发换一张按钮的点击事件
      }
    });
// 设置定时器的时间间隔为1秒
var timerInterval = 1000;

// 上一次换一张按钮的点击事件的时间戳
var lastClickTimestamp = 0;

// 监听鼠标滚轮事件
document.addEventListener('mousewheel', function(e) {
  var currentTimestamp = new Date().getTime(); // 获取当前的时间戳
  if (currentTimestamp - lastClickTimestamp > timerInterval || lastClickTimestamp === 0) { // 如果距离上一次点击的时间已经超过了定时器的时间间隔，或者是第一次点击
    document.getElementById('refresh-btn').click(); // 触发换一张按钮的点击事件
    lastClickTimestamp = currentTimestamp; // 更新上一次点击的时间戳
  }
});
  </script>
  <!-- 引入 Font Awesome JS 文件 -->
  <script src="https://lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="app.js"></script>
</body>
</html>