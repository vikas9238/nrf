<div>
    <section class="info-section">
      <div class="info-details container flex">
        <div class="info-detail-sec">
          <i class="fa-solid fa-location-dot"></i>
          <h4>Adress :</h4>
          <p>
          <?php echo  $_settings->info('address') ?>
          </p>
        </div>

        <div class="info-detail-sec">
          <i class="fa-solid fa-phone"></i>
          <h4>PHONE NO</h4>
          <p>
            <a href="tel:<?php echo  $_settings->info('mobile') ?>" style="color: black">+91 <?php echo  $_settings->info('mobile') ?></a>
          </p>
        </div>

        <div class="info-detail-sec">
          <i class="fa-solid fa-message"></i>
          <h4>EMAIL</h4>
          <p>
            <a
              href="mailto:<?php echo  $_settings->info('email') ?>"
              style="color: black"
              ><?php echo  $_settings->info('email') ?></a
            >
          </p>
        </div>

        <div class="info-detail-sec">
          <i class="fa-solid fa-globe"></i>
          <h4>WEBSITE</h4>
          <p>
            <a href="http://www.nrfindustry.in"
              >www.nrfindustry.in</a
            >
          </p>
        </div>
      </div>
    </section>

    <!-- Contact Us Form .....STARTED..... -->

    <div class="contact-info-row-02">
      <div class="gaping-form container flex">
        <div class="contact-info-row-02-info">
          <h4 class="contact-info-row-02-info-h4">Contact Us</h4>
          <p class="contact-info-row-02-info-p">Please Enter Your Query</p>

          <form id="contact_form" action="">
            <div class="from-float-type">
              <p class="form-p">FULL NAME</p>
              <input
                type="text"
                placeholder="Name"
                name="name"
                class="input-form"
                id="name"
                required
              />
            </div>

            <div class="from-float-type-margin">
              <p class="form-p">EMAIL ADDRESS</p>
              <input
                type="email"
                name="email"
                placeholder="Email"
                class="input-form"
                id="email"
                required
              />
            </div>

            <p class="form-p">SUBJECT</p>
            <input
              type="text"
              placeholder="Subject"
              name="subject"
              class="input-decor input-form"
              id="subject"
              required
            />

            <p class="form-p">MESSAGE</p>
            <input
              type="text"
              placeholder="Message"
              name="message"
              class="input-form"
              id="message"
              required
            />

            <div class="center-btn flex">
              <button type="submit" class="primary-button">Send Message</button>
            </div>
          </form>
        </div>

        <div class="contact-info-row-02-img">
          <img
            src="<?php echo base_url ?>uploads/call-to-action.jpg"
            alt=""
            width="500px"
            height="420px"
            style="
              box-shadow: 0px 0px 5px 8px rgba(0, 0, 0, 0.264);
              margin-block: 10px;
            "
          />
        </div>
      </div>
    </div>
</div>
<style>
      .container{
      max-width: 1250px;
      margin-inline: auto;
      padding-inline: 20px;
      overflow: hidden;
  }
  .flex{
      display: flex;
      align-items: center;
  }
  .primary-button{
      background-color: #ff003a;
      border: 1px solid #ffffff;
      box-shadow: rgba(0, 0, 0, 0.1) 0px 3px 5px 0px;
      border-radius: 4px;
      padding: 12px 24px;
      color: #ffffff;
      font-weight: 600;
      margin-left: 1.2rem;
  }
  .primary-button:hover{
      background-color: #ffffff;
      color: #ff003a;
      border: 1px solid #ff003a;
  }
  .button-gap:hover{
      box-shadow: -1px 2px 10px 8px #ff003a8e;

  }
      /* Information Details */

  .info-section{
      text-align: center;
      padding-block: 40px;
  } 
  .info-details{
      justify-content: space-between;
  }

  .info-detail-sec{
      width: 23%;
      padding: 15px;
  }
  .info-detail-sec p a{
      color: black;
  }
  .info-detail-sec i{
      /* color: #ff003a; */
      color: #00B98E;
      font-size: 3rem;
      padding-bottom: .8rem;
  }
  .info-detail-sec h4{
      padding-top: .5rem;
      padding-bottom: .5rem;
  }
  .info-detail-sec p{
      font-size: .8rem;
      padding-block: 1rem;
  }

  /* contact form */


  .contact-info-row-02{
      padding-block: 40px;
      background-image: url(image/backgroundimg.jpg);
      background-repeat: no-repeat;
      background-size: cover;
  }

  .contact-info-row-02-info{
      width: 50%;
  }
  .contact-info-row-02-info-h4{
      font-size: 2rem;
      padding-block: 2rem;
      color: #00B98E;
  }
  .contact-info-row-02-info-p{
      text-align: left;
      font-size: 20px;
      padding-top: 10px;
      padding-bottom: 30px;
      color: rgba(0, 0, 0, 0.418);
      
  }
  .gaping-form{
      gap: 3.2rem;
  }
  .form-p{
      text-align: left;
      font-size: 12px;
      font-weight: bold;
      color: #00B98E;
      padding-bottom: 20px;
      padding-top: 20px;
  }

  .input-form {
      padding-bottom: 1.5rem;
      padding-top: 1.5rem;
      padding-left: 0.6rem;
      border: 0; 
      border-bottom: 1px solid rgba(0, 0, 0, 0.288);
      width: 100%; 
      border-bottom-left-radius: 3px;
      border-bottom-right-radius: 3px;
      outline: none;
      background-color: rgba(255, 255, 255, 0.366);
  }
  form{
      padding-bottom: 2rem;
  }
  .contact-info-row-02-img{
      width: 40%;
  }
  .contact-info-row-02-img img{
      width: 100%;
      border-radius: 30px;
      box-shadow: -5px 2px 4px 8px #42252c6d;
  }
  /* Contact Section CSS ..... Started.... */
  .contactus-section{
      background: linear-gradient(rgb(0, 0, 0, .8), rgb(0, 0, 0, .4)), url(image/become-a-vol.jpg);
      background-repeat: no-repeat;
      background-size: cover;
      padding-block: 7rem;
  }
  .contactus-section-details{
      text-align: center;
  }
  .contactus-section-details h2 {
      color: #ff003a;    
  }
  .contactus-section-details p{
      padding-top: 1.3rem;
      font-size: 1.5rem;
      color: white;
  }
  .contact-home:hover{
      color: #ff003a;
  }
  .center-btn{
      margin-top: 20px;
  }
  @media screen and (max-width : 479px) {

  .primary-button{
      margin-left: 0rem;
  }
  .flex{
      flex-wrap: wrap;
      }

  /* contact us respo */

  .contactus-section{

  padding-block: 2rem;
  }

  .contactus-section-details h2{
  font-size: 1.3rem;
  }
  .contactus-section-details p{
  padding-top: 0rem;
  font-size: 0.8rem;
  }

  .info-details{
  flex-direction: column;
  text-align: center;
  }
  .info-detail-sec{
  width: 100%
  }
  .contact-info-row-02-img{
  display: none;
  }
  .contact-info-row-02-info{
  width: 100%;
  }
  .contact-info-row-02-info-h4{
  text-align: center;
  }
  .contact-info-row-02-info-p{
  text-align: center;
  }
  .center-btn{
  justify-content: center;
  }
  }
</style>
<script>
    $(function(){
        $('#contact_form').submit(function(e){
            e.preventDefault()
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            $.ajax({
                url:_base_url_+'classes/Master.php?f=contact_us',
                method:'POST',
                data:$(this).serialize(),
                dataType:'json',
                error:err=>{
                    console.log(err)
                    Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                            });
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                      end_loader()
                        Swal.fire({
                                    title: "Form Submitted!",
                                    text: "NRF Team Contact You as soon as possible.",
                                    icon: "success"
                                  });
                        setTimeout(function(){
                            location.reload()
                        },3000)
                    }else if(resp.status == 'error'){
                        $('#contact_form').prepend('<div class="alert alert-danger err-msg">'+resp.message+'</div>')
                        end_loader()
                    }else{
                        alert_toast("an error occured",'error')
                        end_loader()
                    }
                }
            })
        })
    })
</script>