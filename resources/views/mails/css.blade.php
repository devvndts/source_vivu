	<style>
        :root { --bg-primary: #F4F4F4; --color-primary: #FFD928; --font-primary: 'Quicksand', sans-serif; --content-width: 1320px; }
        body{background:#ebebeb;font-family: 'arial';font-size: 14px;}
        img { max-width: 100%; display: inline-block;}

        a { text-decoration: none !important; }

        p {margin:0;}

        .cls-11, .cls-12, .cls-13 { stroke-dasharray: 1100; stroke-dashoffset: 1100; fill-opacity: 0.2; -webkit-animation-timing-function: ease-in-out; animation-timing-function: ease-in-out; -webkit-animation-fill-mode: forwards; animation-fill-mode: forwards; -webkit-animation-iteration-count: infinite; animation-iteration-count: infinite; -webkit-animation-name: DrawLine, FillIn; animation-name: DrawLine, FillIn; -webkit-animation-duration: 5s, 5s; animation-duration: 5s, 5s; -webkit-animation-delay: 0s, 0s; animation-delay: 0s, 0s; -webkit-animation-direction: alternate; animation-direction: alternate; }
        @-webkit-keyframes DrawLine { to { stroke-dashOffset: 0; } }
        @keyframes DrawLine { to { stroke-dashOffset: 0; } }
        @-webkit-keyframes FadeStroke { from { stroke-opacity: 1; }
        to { stroke-opacity: 0; } }
        @keyframes FadeStroke { from { stroke-opacity: 1; }
        to { stroke-opacity: 0; } }
        @-webkit-keyframes FillIn { to { fill-opacity: 1; } }
        @keyframes FillIn { to { fill-opacity: 1; } }

        /** Header **/
        .mail-main-contain{background-color: #ebebeb; padding: 2% 0;}
        .mail-container{background-color: #fff;max-width: 800px;margin: 3% auto;box-shadow: 0px 0px 20px #ebebeb;}
        .mail-table-header{width: 100%; text-align: center;border-collapse: collapse;border-radius: 0 0 15px 15px;overflow: hidden;}
        .mail-table-header tr td{background: #333;color: #d7d5d5; padding: 10px 5px;}
        .mail-table-header tr td a{color: #d7d5d5 !important;}
        .mail-table-header tr td span{vertical-align: middle;display: inline-block;margin-right: 3px;}
        .mail-logo-mikotech{text-align: center; padding: 6% 5px;}


        /** Body **/
        .mail-body{padding: 20px;}
        .mail-content-inform{position: relative;font-size: 15px;min-height: 300px;white-space: pre-line;}
        .mail-logo-main{position: absolute;top: 0;left: 0;width: 100%;height: 100%; background-size: contain;opacity: 0.1;}
        .mail-text-stick{font-style: italic; font-size: 13px; background: #fafafa; padding: 15px 20px;text-align: center;}
        .mail-title{font-weight: bold;}

        .mail-table-tindang{border-collapse: collapse; margin-top: 20px ; font-size: 14px;width: 100%;}
        .mail-table-tindang tr td:nth-child(1){font-size: 12px;}
        .mail-table-tindang tr td:nth-child(2){padding-left: 15px;}
        .mail-table-tindang tr td{background: #fafafa; border: 1px solid #ebebeb; padding: 5px 10px;}
        .mail-link-active{background-color: #ebebeb;padding: 10px; border-radius: 10px;margin-top: 10px;}

        /** Footer **/
        .mail-footer{padding: 40px 20px;text-align: center; font-size: 14px; color: #fff;}
        .mail-footer a{color: #720505;font-weight: bold;}

        /** MAIL **/
        .mail-form-inform{background: rgba(255,255,255,0.7); padding: 20px 10px;}
        .mail-order-title{color: #26b99a; font-weight: bold;font-size: 14px;border-bottom: 1px solid #ccc; padding-bottom: 5px;}
        .mail-order-title span{font-weight: 100;font-size: 12px;color: #666;margin-left: 10px;}
        .mail-table-orderinfor {border-collapse: collapse;}
        .mail-table-orderinfor td{width: 50%;vertical-align: top;font-size: 13px;}
        .mail-table-orderinfor thead{font-weight: bold;}
        .mail-table-orderinfor tbody td{font-size: 13px;line-height: 1.5;padding: 10px 0;}
        .mail-table-orderfooter span{}

        .mail-table-ordermain{border-collapse: collapse;width: 100%;font-size: 13px;background: #fafafa;}
        .mail-table-ordermain thead{font-weight: bold;background: #ebebeb;}
        .mail-table-ordermain td{width: calc(100% / 3);padding: 10px;}
        .mail-table-ordermain td:first-child{width: 50%;}
        .mail-table-ordermain td:nth-child(2){text-align: center;}
        .mail-table-ordermain td:nth-child(3){text-align: right;}
        .mail-table-ordermain tbody tr{border-bottom: 1px dashed #ebebeb;}
    </style>
