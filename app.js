// 获取刷新按钮和图片元素
var refreshBtn = document.getElementById('refresh-btn');
var img = document.querySelector('img');

// 当点击刷新按钮时，发送 Ajax 请求获取新的图片地址，并替换当前图片
refreshBtn.addEventListener('click', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_image_url.php'); // 根据实际情况修改请求的 URL
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            img.src = xhr.responseText;
        }
    };
    xhr.send();
});