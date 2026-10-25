<!-- Preloader -->
<div id="preloader" style="display: none">
  <div id="status">&nbsp;</div>
</div>

<style>
  #preloader {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(255, 255, 255, 0.75);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 99999;
  }

  #status {
    width: 200px;
    height: 200px;
    position: absolute;
    left: 50%;
    top: 50%;
    background-image: url(https://raw.githubusercontent.com/niklausgerber/PreLoadMe/master/img/status.gif);
    background-repeat: no-repeat;
    background-position: center;
    margin: -100px 0 0 -100px;
  }
</style>
