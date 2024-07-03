<!DOCTYPE html>
<html>
<head>
    <title>ECOMMERCE WEBSITE DOWNLOAD</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: #010f1c;
            font-family: "Jost", sans-serif;
            ;
        }

        body {
            background: #efefef;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            width: 100%;
        }

        section {
            max-width: 95%;
            max-height: 90vh;
            width: 600px;
            background: #fff;
            padding: 40px;
            overflow-y: auto;
            border-top: 10px solid #0989ff;
            ;

        }

        .flex {
            display: flex;
            flex-direction: column;
        }

        .flex input {
            border: none;
            outline: none;
            padding: 0px 20px;
            height: 50px;
            width: 100%;
            border: 1px solid #e8e8e8;
        }

        .m10 {
            margin-top: 10px;

        }

        .m20 {
            margin-top: 20px;
        }

        button {
            width: 200px;
            border: none;
            outline: none;
            cursor: pointer;
            height: 50px;
            background: #0989ff;
            color: #fff;
            padding: 0px 20px;

        }

        input:focus {
            border: 1px solid #0989ff;
        }

        button:hover {
            background: #0870d0;
        }

        .get_qr {

            height: 200px;
            width: 200px;
            border: 1px solid #999;
            background: #efefef;
        }

        .qr_code {
            width: 100%;
            height: 100%;
            display: none;
        }

        p {
            color: #7a7a7a;
            font-size: 16px;
            line-height: 24px
        }

        .im {
            max-width: 100%;
            width: 300px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".generate_qr").click(function() {
                $(".form").hide();
                $(".qr_code").show();
                var num = $(".number").val();
                var link = "upi://pay?pa=onkarjha2003@sbi%26am=1500%26tn=" + num;
                var upi = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" + link;
                console.log(upi);
                $(".get_qr").attr("src", upi);
            });
            $(".download_now").click(function() {
                var name = $(".name").val();
                var num = $(".number").val();
                var email = $(".email").val();
                var id = $(".id").val();
                if (num != "" && name != "" && email != "" && id != "") {
                    /*$.post("back.php",{name:name,num:num,email:email,id:id},function(res) {
                    	if(res==1){

                    	}
                    	else{

                    	}
                    });*/
                } else {
                    alert("Fill all fields correctly");
                }
            });
        });
    </script>
</head>

<body>
    <section>
        <h1>ECOMMERCE WEBSITE CODE</h1>
        <div class="form">
            <div class="flex m20">
                <label>Full Name*</label>
                <input type="text" name="name" placeholder="Full Name" class="m10 name">
            </div>
            <div class="flex m20">
                <label>Whatsapp Number(With ISD)*</label>
                <input type="text" name="phone" placeholder="Ex- +919064973840" class="m10 number">
            </div>
            <div class="flex m20">
                <label>Email*</label>
                <input type="email" name="email" placeholder="Email" class="m10 email">
            </div>
            <div class="flex m20">

                <button class="generate_qr">NEXT</button>
            </div>
        </div>
        <div class="qr_code m20">
            <p>Scan the QR Code with any UPI App and pay the amount then download the source code.</p>
            <center><img src="" alt="QR CODE" class="get_qr m10"></center>
            <center><img src="1.png" class="im m10"></center>
            <div class="flex m20">
                <label>UTR/REFERENCE/TRANSACTION ID**</label>
                <input type="number" name="email" placeholder="UTR/REFERENCE/TRANSACTION ID**" class="m10 id">
            </div>
            <button class="download_now m20">Download Now</button>
        </div>
    </section>
</body>

</html>