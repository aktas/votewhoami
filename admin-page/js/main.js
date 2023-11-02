
try{
    document.getElementById("flexSwitchCheckChecked").checked = true;
    $('.dropdown-toggle').dropdown();

    /*  FORM FİLE INPUT START */
    $("form").on("change",".file-upload-field",function(){
        $(this).parent(".file-upload-wrapper").attr("data-text",$(this).val().replace(/.*(\/|\\)/,''));
    });
    /*  FORM FİLE INPUT END */
    // MENU OP-CL START
    let opCl = document.querySelector("#opCl");
    let sidebar = document.querySelector("#sidebar");
    let container = document.querySelector(".my-container");
    opCl.addEventListener("click",function(){       
        if($("#opCl").attr("class") == "fas fa-list-ul"){
            $("#opCl").attr("class","fas fa-times");
        }else{
            $("#opCl").attr("class","fas fa-list-ul");
        }
        $("#page-name").toggle('slow');
        sidebar.classList.toggle("active-nav");
        container.classList.toggle("active-cont");
    });
    // MENU OP-CL END
    // DARKMODE START
    let darkMode = document.querySelector("#flexSwitchCheckChecked");
    darkMode.addEventListener("click",function(){
        if($('#flexSwitchCheckChecked').is(':checked') == true){
            $("body").css("color","white").css("background","#181818");
            $("#employees-stats .table-responsive table").css("color","white");
            $(".showNumUp i").css("color","rgba(245,245,245,.4)");
            $(".row div div").css("background","#353644");
            $("#tasks .checkmark").css("background","none");
            $(".dashboardContactConversation div").css("background","none");
            $("#dashboardContactMessageList").css("background","white");
            $("#dashboardContactMessageList .message-row").css("background","white");
            $("#dashboardContactMessageList .message-row .message-content").css("background","white");
            $("#dashboardContactMessageList .message-row .message-time").css("background","white");
            $("#dashboardContactMessageList .you-message .message-text").css("color","white").css("background","linear-gradient(#9f1eb4,#b41eaf)");
            $("#dashboardContactMessageList .other-message .message-text").css("background","#eee");
            $("#example").attr("class","table table-striped table-dark table-bordered dt-responsive nowrap");
            $("input[class='form-control'],textarea[class='form-control'],select[class='form-control']").css("color","white").css("background","none").css("border","1px solid #5f5f5f");
            $(".my-container .row.gx-1 > div > div").css("color","#ddd");
        }else{
            
            $("body").css("color","black").css("background","#f6f6f6");
            $("#employees-stats .table-responsive table").css("color","black");
            $(".showNumUp i").css("color","rgba(0,0,0,.4)");
            $(".row div div").css("background","white");
            $("#tasks .checkmark").css("background","#878787");
            $("#dashboardContactMessageList .you-message .message-text").css("background","linear-gradient(#9f1eb4,#b41eaf)");
            $("#dashboardContactMessageList .other-message .message-text").css("background","#eee");
            $(".dashboardContactConversation div").css("background","none"); 
            $("#example").attr("class","table table-striped table-bordered dt-responsive nowrap");
            $("input[class='form-control'],textarea[class='form-control'],select[class='form-control']").css("color","black ").css("background","#fdfdfd ").css("border","1px solid #ddd");
            $(".my-container .row.gx-1 > div > div").css("color","black");
            $(".header").css("color","#fff");
            

        }
    });
    // DARKMODE END
    // SIDEBAR COLOR START
    let sidebarSetting = document.querySelector(".color-setting");
    sidebarSetting.addEventListener("click",function(){
        $(".color-setting-area").toggle('fast');
    });

    function sidebarColor($color){
        if($color == "blue"){
            $("#sidebar").css("background","linear-gradient(#0188ff,#010dff)");
            $("#top-color").css("background","#0188ff");
        }else if($color == "purple"){
            $("#sidebar").css("background","linear-gradient(#9f1eb4,#b41eaf)");
            $("#top-color").css("background","#9f1eb4");
        }else{
            $("#sidebar").css("background","linear-gradient(#fda105,#fd7d05)");
            $("#top-color").css("background","#fda105");
        }
    }
    // SIDEBAR COLOR END
    
    // SOUND START
    function sound($val){
        if($val == "beep"){
            var snd = new Audio("sounds/beep.wav"); 
        }else if($val == "pop-up"){
            var snd = new Audio("sounds/pop-up.wav"); 
        }else if($val == "select"){
            var snd = new Audio("sounds/select.wav"); 
        }else if($val == "checked"){
            var snd = new Audio("sounds/checked.wav"); 
        }else if($val == "notification"){
            var snd = new Audio("sounds/notification.wav"); 
        }else{
            var snd = new Audio("sounds/pop-up.wav"); 
        }
        snd.play();
    }
    // SOUND END
    // NOTIFICATION START 
    // DETAIL LİNK -> https://codeseven.github.io/toastr/demo.html
    function showToastr($type,$message,$progress=0,$sound=0){ // showToastr("success","İşlem Başarılı!",1,1); şeklinde göster
        if($sound == 1){
            var snd2 = new Audio("sounds/pop-up.wav"); 
            snd2.play();
        }
        if($progress == 1){
             toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            } 
        }else{
            toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": false,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
        }
        
        toastr[$type]($message); 
        
    }
   
    // NOTIFICATION END

    

}catch(err){
    // alert("Hata bulundu.")
}

