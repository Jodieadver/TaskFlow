<template>
  <!-- 全屏固定背景 -->
  <div class="fluid-bg" aria-hidden="true">
    <!-- 背景底色 -->
    <div class="base"></div>

    <!-- 使用 SVG 滤镜制造“流动雾气” -->
    <svg class="fx" width="0" height="0">
      <filter id="noise">
        <!-- 分形噪声 -->
        <feTurbulence type="fractalNoise"
                      baseFrequency="0.008 0.012"
                      numOctaves="3"
                      seed="2"
                      result="turb" />
        <!-- 缓慢移动制造流动感 -->
        <animate xlink:href="#turb"
                 attributeName="seed"
                 from="2" to="200"
                 dur="18s" repeatCount="indefinite" />
        <!-- 位移图制造“雾化/扭曲” -->
        <feDisplacementMap in="SourceGraphic" in2="turb"
                            scale="60" xChannelSelector="R" yChannelSelector="G"/>
      </filter>
    </svg>

    <!-- 两层发光渐变 + 滤镜 -->
    <div class="layer glow glow-1" />
    <div class="layer glow glow-2" />
    <!-- 顶部黑到透明的渐变遮罩，营造中心高亮、边缘暗 -->
    <div class="vignette" />
  </div>
</template>

<script setup>
// 无需 JS 逻辑，纯样式驱动
</script>

<style scoped>
.fluid-bg{
  position: fixed; inset: 0;
  pointer-events: none;         /* 不挡交互 */
  z-index: -1;                  /* 置于内容后面 */
  overflow: hidden;
}
.base{
  position:absolute; inset:0;
  background: #000;             /* 页面主色：黑 */
}
/* 使用滤镜的层 */
.layer{
  position:absolute; inset:-10%; /* 加大画布避免边缘抽动 */
  filter: url(#noise);
  opacity: .65;
  mix-blend-mode: screen;        /* 叠加发光 */
  animation: drift 30s linear infinite alternate;
  will-change: transform, opacity, filter;
}

/* 两个不同的发光渐变，产生层次 */
.glow{
  background:
    radial-gradient(40% 60% at 20% 70%, rgba(255,255,255,.12), rgba(0,0,0,0) 60%),
    radial-gradient(45% 65% at 80% 30%, rgba(255,255,255,.18), rgba(0,0,0,0) 65%),
    radial-gradient(60% 80% at 50% 50%, rgba(255,255,255,.10), rgba(0,0,0,0) 70%);
}
.glow-1{ animation-duration: 28s; transform: translate3d(0,0,0) scale(1.05); }
.glow-2{ animation-duration: 36s; animation-direction: alternate-reverse; opacity:.55; }

.vignette{
  position:absolute; inset:0;
  background:
    radial-gradient(120% 120% at 50% 60%, rgba(255,255,255,.08) 0%, rgba(0,0,0,0) 55%),
    radial-gradient(150% 150% at 50% 120%, rgba(0,0,0,.65) 40%, rgba(0,0,0,.85) 80%);
  mix-blend-mode: normal;
}

/* 缓慢漂移的关键帧 */
@keyframes drift{
  0%   { transform: translate3d(-2%, -1%, 0) scale(1.06); filter: url(#noise); }
  50%  { transform: translate3d(2%, 1%, 0)  scale(1.02); }
  100% { transform: translate3d(-1%, 2%, 0) scale(1.08); }
}

/* 低动效用户：自动降级 */
@media (prefers-reduced-motion: reduce) {
  .layer { animation: none; opacity:.4; }
}
</style>
