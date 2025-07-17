@extends('layouts.guest')

@section('title', 'Registration')

@section('content')

<!-- main content start -->
<main>
    <div class="content">
        <!-- login-form start -->
        <section class="login-form px-4 bg-auth-images"
            style="background-image: linear-gradient(rgb(0 0 0 / 50%), rgb(0 0 0 / 50%)), url('/frontend-css/img/webimg/bg-auth.jpg');">
            <div class="row align-items-center justify-content-center">
                <!-- <div class="col-md-6">
                    <div class="d-none d-md-block">
                        <img class="login-thumb" src="" alt="Art time" loading="lazy">
                    </div>
                </div> -->
                <div class="col-sm-9 col-md-7 col-xxl-5" data-aos="fade-up" data-aos-duration="2000">
                    <div class="p-4">
                        <div class="form-box-container jacques">
                             <form id="registerForm" action="{{ route('frontend.register.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row form-box">
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label" for="f_name">First Name</label>
                                        <input class="form-control" type="text" name="f_name" id="f_name"
                                            placeholder="Enter your first name">
                                            <span class="invalid-feedback" data-field="f_name"></span>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label" for="l_name">Last Name</label>
                                        <input class="form-control" type="text" name="l_name" id="l_name"
                                            placeholder="Enter your last name">
                                        <span class="invalid-feedback" data-field="l_name"></span>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label" for="email">Email</label>
                                        <input class="form-control" type="email" name="email" id="email"
                                            placeholder="Enter your email">
                                            <span class="invalid-feedback" data-field="email"></span>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label" for="country">Select Country</label>
                                        <select type="text" class="form-control" id="country" name="country"
                                            placeholder="country">
                                            <option selected disabled>Select Country</option>
                                            <option
                                                data-country="{&quot;id&quot;:1,&quot;iso&quot;:&quot;AF&quot;,&quot;name&quot;:&quot;AFGHANISTAN&quot;,&quot;nick_name&quot;:&quot;Afghanistan&quot;,&quot;iso3&quot;:&quot;AFG&quot;,&quot;num_code&quot;:&quot;4&quot;,&quot;phone_code&quot;:&quot;93&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="AFGHANISTAN">AFGHANISTAN</option>
                                            <option
                                                data-country="{&quot;id&quot;:2,&quot;iso&quot;:&quot;AL&quot;,&quot;name&quot;:&quot;ALBANIA&quot;,&quot;nick_name&quot;:&quot;Albania&quot;,&quot;iso3&quot;:&quot;ALB&quot;,&quot;num_code&quot;:&quot;8&quot;,&quot;phone_code&quot;:&quot;355&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ALBANIA">ALBANIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:3,&quot;iso&quot;:&quot;DZ&quot;,&quot;name&quot;:&quot;ALGERIA&quot;,&quot;nick_name&quot;:&quot;Algeria&quot;,&quot;iso3&quot;:&quot;DZA&quot;,&quot;num_code&quot;:&quot;12&quot;,&quot;phone_code&quot;:&quot;213&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ALGERIA">ALGERIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:4,&quot;iso&quot;:&quot;AS&quot;,&quot;name&quot;:&quot;AMERICAN SAMOA&quot;,&quot;nick_name&quot;:&quot;American Samoa&quot;,&quot;iso3&quot;:&quot;ASM&quot;,&quot;num_code&quot;:&quot;16&quot;,&quot;phone_code&quot;:&quot;1684&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="AMERICAN SAMOA">AMERICAN SAMOA</option>
                                            <option
                                                data-country="{&quot;id&quot;:5,&quot;iso&quot;:&quot;AD&quot;,&quot;name&quot;:&quot;ANDORRA&quot;,&quot;nick_name&quot;:&quot;Andorra&quot;,&quot;iso3&quot;:&quot;AND&quot;,&quot;num_code&quot;:&quot;20&quot;,&quot;phone_code&quot;:&quot;376&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ANDORRA">ANDORRA</option>
                                            <option
                                                data-country="{&quot;id&quot;:6,&quot;iso&quot;:&quot;AO&quot;,&quot;name&quot;:&quot;ANGOLA&quot;,&quot;nick_name&quot;:&quot;Angola&quot;,&quot;iso3&quot;:&quot;AGO&quot;,&quot;num_code&quot;:&quot;24&quot;,&quot;phone_code&quot;:&quot;244&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ANGOLA">ANGOLA</option>
                                            <option
                                                data-country="{&quot;id&quot;:7,&quot;iso&quot;:&quot;AI&quot;,&quot;name&quot;:&quot;ANGUILLA&quot;,&quot;nick_name&quot;:&quot;Anguilla&quot;,&quot;iso3&quot;:&quot;AIA&quot;,&quot;num_code&quot;:&quot;660&quot;,&quot;phone_code&quot;:&quot;1264&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ANGUILLA">ANGUILLA</option>
                                            <option
                                                data-country="{&quot;id&quot;:8,&quot;iso&quot;:&quot;AG&quot;,&quot;name&quot;:&quot;ANTIGUA AND BARBUDA&quot;,&quot;nick_name&quot;:&quot;Antigua and Barbuda&quot;,&quot;iso3&quot;:&quot;ATG&quot;,&quot;num_code&quot;:&quot;28&quot;,&quot;phone_code&quot;:&quot;1268&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ANTIGUA AND BARBUDA">ANTIGUA AND BARBUDA</option>
                                            <option
                                                data-country="{&quot;id&quot;:9,&quot;iso&quot;:&quot;AR&quot;,&quot;name&quot;:&quot;ARGENTINA&quot;,&quot;nick_name&quot;:&quot;Argentina&quot;,&quot;iso3&quot;:&quot;ARG&quot;,&quot;num_code&quot;:&quot;32&quot;,&quot;phone_code&quot;:&quot;54&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ARGENTINA">ARGENTINA</option>
                                            <option
                                                data-country="{&quot;id&quot;:10,&quot;iso&quot;:&quot;AM&quot;,&quot;name&quot;:&quot;ARMENIA&quot;,&quot;nick_name&quot;:&quot;Armenia&quot;,&quot;iso3&quot;:&quot;ARM&quot;,&quot;num_code&quot;:&quot;51&quot;,&quot;phone_code&quot;:&quot;374&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ARMENIA">ARMENIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:11,&quot;iso&quot;:&quot;AW&quot;,&quot;name&quot;:&quot;ARUBA&quot;,&quot;nick_name&quot;:&quot;Aruba&quot;,&quot;iso3&quot;:&quot;ABW&quot;,&quot;num_code&quot;:&quot;533&quot;,&quot;phone_code&quot;:&quot;297&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ARUBA">ARUBA</option>
                                            <option
                                                data-country="{&quot;id&quot;:12,&quot;iso&quot;:&quot;AU&quot;,&quot;name&quot;:&quot;AUSTRALIA&quot;,&quot;nick_name&quot;:&quot;Australia&quot;,&quot;iso3&quot;:&quot;AUS&quot;,&quot;num_code&quot;:&quot;36&quot;,&quot;phone_code&quot;:&quot;61&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="AUSTRALIA">AUSTRALIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:13,&quot;iso&quot;:&quot;AT&quot;,&quot;name&quot;:&quot;AUSTRIA&quot;,&quot;nick_name&quot;:&quot;Austria&quot;,&quot;iso3&quot;:&quot;AUT&quot;,&quot;num_code&quot;:&quot;40&quot;,&quot;phone_code&quot;:&quot;43&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="AUSTRIA">AUSTRIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:14,&quot;iso&quot;:&quot;AZ&quot;,&quot;name&quot;:&quot;AZERBAIJAN&quot;,&quot;nick_name&quot;:&quot;Azerbaijan&quot;,&quot;iso3&quot;:&quot;AZE&quot;,&quot;num_code&quot;:&quot;31&quot;,&quot;phone_code&quot;:&quot;994&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="AZERBAIJAN">AZERBAIJAN</option>
                                            <option
                                                data-country="{&quot;id&quot;:15,&quot;iso&quot;:&quot;BS&quot;,&quot;name&quot;:&quot;BAHAMAS&quot;,&quot;nick_name&quot;:&quot;Bahamas&quot;,&quot;iso3&quot;:&quot;BHS&quot;,&quot;num_code&quot;:&quot;44&quot;,&quot;phone_code&quot;:&quot;1242&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BAHAMAS">BAHAMAS</option>
                                            <option
                                                data-country="{&quot;id&quot;:16,&quot;iso&quot;:&quot;BH&quot;,&quot;name&quot;:&quot;BAHRAIN&quot;,&quot;nick_name&quot;:&quot;Bahrain&quot;,&quot;iso3&quot;:&quot;BHR&quot;,&quot;num_code&quot;:&quot;48&quot;,&quot;phone_code&quot;:&quot;973&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BAHRAIN">BAHRAIN</option>
                                            <option
                                                data-country="{&quot;id&quot;:17,&quot;iso&quot;:&quot;BD&quot;,&quot;name&quot;:&quot;BANGLADESH&quot;,&quot;nick_name&quot;:&quot;Bangladesh&quot;,&quot;iso3&quot;:&quot;BGD&quot;,&quot;num_code&quot;:&quot;50&quot;,&quot;phone_code&quot;:&quot;880&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BANGLADESH">BANGLADESH</option>
                                            <option
                                                data-country="{&quot;id&quot;:18,&quot;iso&quot;:&quot;BB&quot;,&quot;name&quot;:&quot;BARBADOS&quot;,&quot;nick_name&quot;:&quot;Barbados&quot;,&quot;iso3&quot;:&quot;BRB&quot;,&quot;num_code&quot;:&quot;52&quot;,&quot;phone_code&quot;:&quot;1246&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BARBADOS">BARBADOS</option>
                                            <option
                                                data-country="{&quot;id&quot;:19,&quot;iso&quot;:&quot;BY&quot;,&quot;name&quot;:&quot;BELARUS&quot;,&quot;nick_name&quot;:&quot;Belarus&quot;,&quot;iso3&quot;:&quot;BLR&quot;,&quot;num_code&quot;:&quot;112&quot;,&quot;phone_code&quot;:&quot;375&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BELARUS">BELARUS</option>
                                            <option
                                                data-country="{&quot;id&quot;:20,&quot;iso&quot;:&quot;BE&quot;,&quot;name&quot;:&quot;BELGIUM&quot;,&quot;nick_name&quot;:&quot;Belgium&quot;,&quot;iso3&quot;:&quot;BEL&quot;,&quot;num_code&quot;:&quot;56&quot;,&quot;phone_code&quot;:&quot;32&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BELGIUM">BELGIUM</option>
                                            <option
                                                data-country="{&quot;id&quot;:21,&quot;iso&quot;:&quot;BZ&quot;,&quot;name&quot;:&quot;BELIZE&quot;,&quot;nick_name&quot;:&quot;Belize&quot;,&quot;iso3&quot;:&quot;BLZ&quot;,&quot;num_code&quot;:&quot;84&quot;,&quot;phone_code&quot;:&quot;501&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BELIZE">BELIZE</option>
                                            <option
                                                data-country="{&quot;id&quot;:22,&quot;iso&quot;:&quot;BJ&quot;,&quot;name&quot;:&quot;BENIN&quot;,&quot;nick_name&quot;:&quot;Benin&quot;,&quot;iso3&quot;:&quot;BEN&quot;,&quot;num_code&quot;:&quot;204&quot;,&quot;phone_code&quot;:&quot;229&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BENIN">BENIN</option>
                                            <option
                                                data-country="{&quot;id&quot;:23,&quot;iso&quot;:&quot;BM&quot;,&quot;name&quot;:&quot;BERMUDA&quot;,&quot;nick_name&quot;:&quot;Bermuda&quot;,&quot;iso3&quot;:&quot;BMU&quot;,&quot;num_code&quot;:&quot;60&quot;,&quot;phone_code&quot;:&quot;1441&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BERMUDA">BERMUDA</option>
                                            <option
                                                data-country="{&quot;id&quot;:24,&quot;iso&quot;:&quot;BT&quot;,&quot;name&quot;:&quot;BHUTAN&quot;,&quot;nick_name&quot;:&quot;Bhutan&quot;,&quot;iso3&quot;:&quot;BTN&quot;,&quot;num_code&quot;:&quot;64&quot;,&quot;phone_code&quot;:&quot;975&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BHUTAN">BHUTAN</option>
                                            <option
                                                data-country="{&quot;id&quot;:25,&quot;iso&quot;:&quot;BO&quot;,&quot;name&quot;:&quot;BOLIVIA&quot;,&quot;nick_name&quot;:&quot;Bolivia&quot;,&quot;iso3&quot;:&quot;BOL&quot;,&quot;num_code&quot;:&quot;68&quot;,&quot;phone_code&quot;:&quot;591&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BOLIVIA">BOLIVIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:26,&quot;iso&quot;:&quot;BA&quot;,&quot;name&quot;:&quot;BOSNIA AND HERZEGOVINA&quot;,&quot;nick_name&quot;:&quot;Bosnia and Herzegovina&quot;,&quot;iso3&quot;:&quot;BIH&quot;,&quot;num_code&quot;:&quot;70&quot;,&quot;phone_code&quot;:&quot;387&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BOSNIA AND HERZEGOVINA">BOSNIA AND HERZEGOVINA</option>
                                            <option
                                                data-country="{&quot;id&quot;:27,&quot;iso&quot;:&quot;BW&quot;,&quot;name&quot;:&quot;BOTSWANA&quot;,&quot;nick_name&quot;:&quot;Botswana&quot;,&quot;iso3&quot;:&quot;BWA&quot;,&quot;num_code&quot;:&quot;72&quot;,&quot;phone_code&quot;:&quot;267&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BOTSWANA">BOTSWANA</option>
                                            <option
                                                data-country="{&quot;id&quot;:28,&quot;iso&quot;:&quot;BR&quot;,&quot;name&quot;:&quot;BRAZIL&quot;,&quot;nick_name&quot;:&quot;Brazil&quot;,&quot;iso3&quot;:&quot;BRA&quot;,&quot;num_code&quot;:&quot;76&quot;,&quot;phone_code&quot;:&quot;55&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BRAZIL">BRAZIL</option>
                                            <option
                                                data-country="{&quot;id&quot;:29,&quot;iso&quot;:&quot;BN&quot;,&quot;name&quot;:&quot;BRUNEI DARUSSALAM&quot;,&quot;nick_name&quot;:&quot;Brunei Darussalam&quot;,&quot;iso3&quot;:&quot;BRN&quot;,&quot;num_code&quot;:&quot;96&quot;,&quot;phone_code&quot;:&quot;673&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BRUNEI DARUSSALAM">BRUNEI DARUSSALAM</option>
                                            <option
                                                data-country="{&quot;id&quot;:30,&quot;iso&quot;:&quot;BG&quot;,&quot;name&quot;:&quot;BULGARIA&quot;,&quot;nick_name&quot;:&quot;Bulgaria&quot;,&quot;iso3&quot;:&quot;BGR&quot;,&quot;num_code&quot;:&quot;100&quot;,&quot;phone_code&quot;:&quot;359&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BULGARIA">BULGARIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:31,&quot;iso&quot;:&quot;BF&quot;,&quot;name&quot;:&quot;BURKINA FASO&quot;,&quot;nick_name&quot;:&quot;Burkina Faso&quot;,&quot;iso3&quot;:&quot;BFA&quot;,&quot;num_code&quot;:&quot;854&quot;,&quot;phone_code&quot;:&quot;226&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BURKINA FASO">BURKINA FASO</option>
                                            <option
                                                data-country="{&quot;id&quot;:32,&quot;iso&quot;:&quot;BI&quot;,&quot;name&quot;:&quot;BURUNDI&quot;,&quot;nick_name&quot;:&quot;Burundi&quot;,&quot;iso3&quot;:&quot;BDI&quot;,&quot;num_code&quot;:&quot;108&quot;,&quot;phone_code&quot;:&quot;257&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="BURUNDI">BURUNDI</option>
                                            <option
                                                data-country="{&quot;id&quot;:33,&quot;iso&quot;:&quot;KH&quot;,&quot;name&quot;:&quot;CAMBODIA&quot;,&quot;nick_name&quot;:&quot;Cambodia&quot;,&quot;iso3&quot;:&quot;KHM&quot;,&quot;num_code&quot;:&quot;116&quot;,&quot;phone_code&quot;:&quot;855&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CAMBODIA">CAMBODIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:34,&quot;iso&quot;:&quot;CM&quot;,&quot;name&quot;:&quot;CAMEROON&quot;,&quot;nick_name&quot;:&quot;Cameroon&quot;,&quot;iso3&quot;:&quot;CMR&quot;,&quot;num_code&quot;:&quot;120&quot;,&quot;phone_code&quot;:&quot;237&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CAMEROON">CAMEROON</option>
                                            <option
                                                data-country="{&quot;id&quot;:35,&quot;iso&quot;:&quot;CA&quot;,&quot;name&quot;:&quot;CANADA&quot;,&quot;nick_name&quot;:&quot;Canada&quot;,&quot;iso3&quot;:&quot;CAN&quot;,&quot;num_code&quot;:&quot;124&quot;,&quot;phone_code&quot;:&quot;1&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CANADA">CANADA</option>
                                            <option
                                                data-country="{&quot;id&quot;:36,&quot;iso&quot;:&quot;CV&quot;,&quot;name&quot;:&quot;CAPE VERDE&quot;,&quot;nick_name&quot;:&quot;Cape Verde&quot;,&quot;iso3&quot;:&quot;CPV&quot;,&quot;num_code&quot;:&quot;132&quot;,&quot;phone_code&quot;:&quot;238&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CAPE VERDE">CAPE VERDE</option>
                                            <option
                                                data-country="{&quot;id&quot;:37,&quot;iso&quot;:&quot;KY&quot;,&quot;name&quot;:&quot;CAYMAN ISLANDS&quot;,&quot;nick_name&quot;:&quot;Cayman Islands&quot;,&quot;iso3&quot;:&quot;CYM&quot;,&quot;num_code&quot;:&quot;136&quot;,&quot;phone_code&quot;:&quot;1345&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CAYMAN ISLANDS">CAYMAN ISLANDS</option>
                                            <option
                                                data-country="{&quot;id&quot;:38,&quot;iso&quot;:&quot;CF&quot;,&quot;name&quot;:&quot;CENTRAL AFRICAN REPUBLIC&quot;,&quot;nick_name&quot;:&quot;Central African Republic&quot;,&quot;iso3&quot;:&quot;CAF&quot;,&quot;num_code&quot;:&quot;140&quot;,&quot;phone_code&quot;:&quot;236&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CENTRAL AFRICAN REPUBLIC">CENTRAL AFRICAN REPUBLIC</option>
                                            <option
                                                data-country="{&quot;id&quot;:39,&quot;iso&quot;:&quot;TD&quot;,&quot;name&quot;:&quot;CHAD&quot;,&quot;nick_name&quot;:&quot;Chad&quot;,&quot;iso3&quot;:&quot;TCD&quot;,&quot;num_code&quot;:&quot;148&quot;,&quot;phone_code&quot;:&quot;235&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CHAD">CHAD</option>
                                            <option
                                                data-country="{&quot;id&quot;:40,&quot;iso&quot;:&quot;CL&quot;,&quot;name&quot;:&quot;CHILE&quot;,&quot;nick_name&quot;:&quot;Chile&quot;,&quot;iso3&quot;:&quot;CHL&quot;,&quot;num_code&quot;:&quot;152&quot;,&quot;phone_code&quot;:&quot;56&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CHILE">CHILE</option>
                                            <option
                                                data-country="{&quot;id&quot;:41,&quot;iso&quot;:&quot;CN&quot;,&quot;name&quot;:&quot;CHINA&quot;,&quot;nick_name&quot;:&quot;China&quot;,&quot;iso3&quot;:&quot;CHN&quot;,&quot;num_code&quot;:&quot;156&quot;,&quot;phone_code&quot;:&quot;86&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CHINA">CHINA</option>
                                            <option
                                                data-country="{&quot;id&quot;:42,&quot;iso&quot;:&quot;CO&quot;,&quot;name&quot;:&quot;COLOMBIA&quot;,&quot;nick_name&quot;:&quot;Colombia&quot;,&quot;iso3&quot;:&quot;COL&quot;,&quot;num_code&quot;:&quot;170&quot;,&quot;phone_code&quot;:&quot;57&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="COLOMBIA">COLOMBIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:43,&quot;iso&quot;:&quot;KM&quot;,&quot;name&quot;:&quot;COMOROS&quot;,&quot;nick_name&quot;:&quot;Comoros&quot;,&quot;iso3&quot;:&quot;COM&quot;,&quot;num_code&quot;:&quot;174&quot;,&quot;phone_code&quot;:&quot;269&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="COMOROS">COMOROS</option>
                                            <option
                                                data-country="{&quot;id&quot;:44,&quot;iso&quot;:&quot;CG&quot;,&quot;name&quot;:&quot;CONGO&quot;,&quot;nick_name&quot;:&quot;Congo&quot;,&quot;iso3&quot;:&quot;COG&quot;,&quot;num_code&quot;:&quot;178&quot;,&quot;phone_code&quot;:&quot;242&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CONGO">CONGO</option>
                                            <option
                                                data-country="{&quot;id&quot;:45,&quot;iso&quot;:&quot;CD&quot;,&quot;name&quot;:&quot;CONGO, THE DEMOCRATIC REPUBLIC OF THE&quot;,&quot;nick_name&quot;:&quot;Congo, the Democratic Republic of the&quot;,&quot;iso3&quot;:&quot;COD&quot;,&quot;num_code&quot;:&quot;180&quot;,&quot;phone_code&quot;:&quot;242&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CONGO, THE DEMOCRATIC REPUBLIC OF THE">CONGO, THE DEMOCRATIC
                                                REPUBLIC OF THE</option>
                                            <option
                                                data-country="{&quot;id&quot;:46,&quot;iso&quot;:&quot;CK&quot;,&quot;name&quot;:&quot;COOK ISLANDS&quot;,&quot;nick_name&quot;:&quot;Cook Islands&quot;,&quot;iso3&quot;:&quot;COK&quot;,&quot;num_code&quot;:&quot;184&quot;,&quot;phone_code&quot;:&quot;682&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="COOK ISLANDS">COOK ISLANDS</option>
                                            <option
                                                data-country="{&quot;id&quot;:47,&quot;iso&quot;:&quot;CR&quot;,&quot;name&quot;:&quot;COSTA RICA&quot;,&quot;nick_name&quot;:&quot;Costa Rica&quot;,&quot;iso3&quot;:&quot;CRI&quot;,&quot;num_code&quot;:&quot;188&quot;,&quot;phone_code&quot;:&quot;506&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="COSTA RICA">COSTA RICA</option>
                                            <option
                                                data-country="{&quot;id&quot;:48,&quot;iso&quot;:&quot;CI&quot;,&quot;name&quot;:&quot;COTE D'IVOIRE&quot;,&quot;nick_name&quot;:&quot;Cote D'Ivoire&quot;,&quot;iso3&quot;:&quot;CIV&quot;,&quot;num_code&quot;:&quot;384&quot;,&quot;phone_code&quot;:&quot;225&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="COTE D'IVOIRE">COTE D'IVOIRE</option>
                                            <option
                                                data-country="{&quot;id&quot;:49,&quot;iso&quot;:&quot;HR&quot;,&quot;name&quot;:&quot;CROATIA&quot;,&quot;nick_name&quot;:&quot;Croatia&quot;,&quot;iso3&quot;:&quot;HRV&quot;,&quot;num_code&quot;:&quot;191&quot;,&quot;phone_code&quot;:&quot;385&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CROATIA">CROATIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:50,&quot;iso&quot;:&quot;CU&quot;,&quot;name&quot;:&quot;CUBA&quot;,&quot;nick_name&quot;:&quot;Cuba&quot;,&quot;iso3&quot;:&quot;CUB&quot;,&quot;num_code&quot;:&quot;192&quot;,&quot;phone_code&quot;:&quot;53&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CUBA">CUBA</option>
                                            <option
                                                data-country="{&quot;id&quot;:51,&quot;iso&quot;:&quot;CY&quot;,&quot;name&quot;:&quot;CYPRUS&quot;,&quot;nick_name&quot;:&quot;Cyprus&quot;,&quot;iso3&quot;:&quot;CYP&quot;,&quot;num_code&quot;:&quot;196&quot;,&quot;phone_code&quot;:&quot;357&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CYPRUS">CYPRUS</option>
                                            <option
                                                data-country="{&quot;id&quot;:52,&quot;iso&quot;:&quot;CZ&quot;,&quot;name&quot;:&quot;CZECH REPUBLIC&quot;,&quot;nick_name&quot;:&quot;Czech Republic&quot;,&quot;iso3&quot;:&quot;CZE&quot;,&quot;num_code&quot;:&quot;203&quot;,&quot;phone_code&quot;:&quot;420&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="CZECH REPUBLIC">CZECH REPUBLIC</option>
                                            <option
                                                data-country="{&quot;id&quot;:53,&quot;iso&quot;:&quot;DK&quot;,&quot;name&quot;:&quot;DENMARK&quot;,&quot;nick_name&quot;:&quot;Denmark&quot;,&quot;iso3&quot;:&quot;DNK&quot;,&quot;num_code&quot;:&quot;208&quot;,&quot;phone_code&quot;:&quot;45&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="DENMARK">DENMARK</option>
                                            <option
                                                data-country="{&quot;id&quot;:54,&quot;iso&quot;:&quot;DJ&quot;,&quot;name&quot;:&quot;DJIBOUTI&quot;,&quot;nick_name&quot;:&quot;Djibouti&quot;,&quot;iso3&quot;:&quot;DJI&quot;,&quot;num_code&quot;:&quot;262&quot;,&quot;phone_code&quot;:&quot;253&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="DJIBOUTI">DJIBOUTI</option>
                                            <option
                                                data-country="{&quot;id&quot;:55,&quot;iso&quot;:&quot;DM&quot;,&quot;name&quot;:&quot;DOMINICA&quot;,&quot;nick_name&quot;:&quot;Dominica&quot;,&quot;iso3&quot;:&quot;DMA&quot;,&quot;num_code&quot;:&quot;212&quot;,&quot;phone_code&quot;:&quot;1767&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="DOMINICA">DOMINICA</option>
                                            <option
                                                data-country="{&quot;id&quot;:56,&quot;iso&quot;:&quot;DO&quot;,&quot;name&quot;:&quot;DOMINICAN REPUBLIC&quot;,&quot;nick_name&quot;:&quot;Dominican Republic&quot;,&quot;iso3&quot;:&quot;DOM&quot;,&quot;num_code&quot;:&quot;214&quot;,&quot;phone_code&quot;:&quot;1809&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="DOMINICAN REPUBLIC">DOMINICAN REPUBLIC</option>
                                            <option
                                                data-country="{&quot;id&quot;:57,&quot;iso&quot;:&quot;EC&quot;,&quot;name&quot;:&quot;ECUADOR&quot;,&quot;nick_name&quot;:&quot;Ecuador&quot;,&quot;iso3&quot;:&quot;ECU&quot;,&quot;num_code&quot;:&quot;218&quot;,&quot;phone_code&quot;:&quot;593&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ECUADOR">ECUADOR</option>
                                            <option
                                                data-country="{&quot;id&quot;:58,&quot;iso&quot;:&quot;EG&quot;,&quot;name&quot;:&quot;EGYPT&quot;,&quot;nick_name&quot;:&quot;Egypt&quot;,&quot;iso3&quot;:&quot;EGY&quot;,&quot;num_code&quot;:&quot;818&quot;,&quot;phone_code&quot;:&quot;20&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="EGYPT">EGYPT</option>
                                            <option
                                                data-country="{&quot;id&quot;:59,&quot;iso&quot;:&quot;SV&quot;,&quot;name&quot;:&quot;EL SALVADOR&quot;,&quot;nick_name&quot;:&quot;El Salvador&quot;,&quot;iso3&quot;:&quot;SLV&quot;,&quot;num_code&quot;:&quot;222&quot;,&quot;phone_code&quot;:&quot;503&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="EL SALVADOR">EL SALVADOR</option>
                                            <option
                                                data-country="{&quot;id&quot;:60,&quot;iso&quot;:&quot;GQ&quot;,&quot;name&quot;:&quot;EQUATORIAL GUINEA&quot;,&quot;nick_name&quot;:&quot;Equatorial Guinea&quot;,&quot;iso3&quot;:&quot;GNQ&quot;,&quot;num_code&quot;:&quot;226&quot;,&quot;phone_code&quot;:&quot;240&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="EQUATORIAL GUINEA">EQUATORIAL GUINEA</option>
                                            <option
                                                data-country="{&quot;id&quot;:61,&quot;iso&quot;:&quot;ER&quot;,&quot;name&quot;:&quot;ERITREA&quot;,&quot;nick_name&quot;:&quot;Eritrea&quot;,&quot;iso3&quot;:&quot;ERI&quot;,&quot;num_code&quot;:&quot;232&quot;,&quot;phone_code&quot;:&quot;291&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ERITREA">ERITREA</option>
                                            <option
                                                data-country="{&quot;id&quot;:62,&quot;iso&quot;:&quot;EE&quot;,&quot;name&quot;:&quot;ESTONIA&quot;,&quot;nick_name&quot;:&quot;Estonia&quot;,&quot;iso3&quot;:&quot;EST&quot;,&quot;num_code&quot;:&quot;233&quot;,&quot;phone_code&quot;:&quot;372&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ESTONIA">ESTONIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:63,&quot;iso&quot;:&quot;ET&quot;,&quot;name&quot;:&quot;ETHIOPIA&quot;,&quot;nick_name&quot;:&quot;Ethiopia&quot;,&quot;iso3&quot;:&quot;ETH&quot;,&quot;num_code&quot;:&quot;231&quot;,&quot;phone_code&quot;:&quot;251&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ETHIOPIA">ETHIOPIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:64,&quot;iso&quot;:&quot;FK&quot;,&quot;name&quot;:&quot;FALKLAND ISLANDS (MALVINAS)&quot;,&quot;nick_name&quot;:&quot;Falkland Islands (Malvinas)&quot;,&quot;iso3&quot;:&quot;FLK&quot;,&quot;num_code&quot;:&quot;238&quot;,&quot;phone_code&quot;:&quot;500&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="FALKLAND ISLANDS (MALVINAS)">FALKLAND ISLANDS (MALVINAS)
                                            </option>
                                            <option
                                                data-country="{&quot;id&quot;:65,&quot;iso&quot;:&quot;FO&quot;,&quot;name&quot;:&quot;FAROE ISLANDS&quot;,&quot;nick_name&quot;:&quot;Faroe Islands&quot;,&quot;iso3&quot;:&quot;FRO&quot;,&quot;num_code&quot;:&quot;234&quot;,&quot;phone_code&quot;:&quot;298&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="FAROE ISLANDS">FAROE ISLANDS</option>
                                            <option
                                                data-country="{&quot;id&quot;:66,&quot;iso&quot;:&quot;FJ&quot;,&quot;name&quot;:&quot;FIJI&quot;,&quot;nick_name&quot;:&quot;Fiji&quot;,&quot;iso3&quot;:&quot;FJI&quot;,&quot;num_code&quot;:&quot;242&quot;,&quot;phone_code&quot;:&quot;679&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="FIJI">FIJI</option>
                                            <option
                                                data-country="{&quot;id&quot;:67,&quot;iso&quot;:&quot;FI&quot;,&quot;name&quot;:&quot;FINLAND&quot;,&quot;nick_name&quot;:&quot;Finland&quot;,&quot;iso3&quot;:&quot;FIN&quot;,&quot;num_code&quot;:&quot;246&quot;,&quot;phone_code&quot;:&quot;358&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="FINLAND">FINLAND</option>
                                            <option
                                                data-country="{&quot;id&quot;:68,&quot;iso&quot;:&quot;FR&quot;,&quot;name&quot;:&quot;FRANCE&quot;,&quot;nick_name&quot;:&quot;France&quot;,&quot;iso3&quot;:&quot;FRA&quot;,&quot;num_code&quot;:&quot;250&quot;,&quot;phone_code&quot;:&quot;33&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="FRANCE">FRANCE</option>
                                            <option
                                                data-country="{&quot;id&quot;:69,&quot;iso&quot;:&quot;GF&quot;,&quot;name&quot;:&quot;FRENCH GUIANA&quot;,&quot;nick_name&quot;:&quot;French Guiana&quot;,&quot;iso3&quot;:&quot;GUF&quot;,&quot;num_code&quot;:&quot;254&quot;,&quot;phone_code&quot;:&quot;594&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="FRENCH GUIANA">FRENCH GUIANA</option>
                                            <option
                                                data-country="{&quot;id&quot;:70,&quot;iso&quot;:&quot;PF&quot;,&quot;name&quot;:&quot;FRENCH POLYNESIA&quot;,&quot;nick_name&quot;:&quot;French Polynesia&quot;,&quot;iso3&quot;:&quot;PYF&quot;,&quot;num_code&quot;:&quot;258&quot;,&quot;phone_code&quot;:&quot;689&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="FRENCH POLYNESIA">FRENCH POLYNESIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:71,&quot;iso&quot;:&quot;GA&quot;,&quot;name&quot;:&quot;GABON&quot;,&quot;nick_name&quot;:&quot;Gabon&quot;,&quot;iso3&quot;:&quot;GAB&quot;,&quot;num_code&quot;:&quot;266&quot;,&quot;phone_code&quot;:&quot;241&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GABON">GABON</option>
                                            <option
                                                data-country="{&quot;id&quot;:72,&quot;iso&quot;:&quot;GM&quot;,&quot;name&quot;:&quot;GAMBIA&quot;,&quot;nick_name&quot;:&quot;Gambia&quot;,&quot;iso3&quot;:&quot;GMB&quot;,&quot;num_code&quot;:&quot;270&quot;,&quot;phone_code&quot;:&quot;220&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GAMBIA">GAMBIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:73,&quot;iso&quot;:&quot;GE&quot;,&quot;name&quot;:&quot;GEORGIA&quot;,&quot;nick_name&quot;:&quot;Georgia&quot;,&quot;iso3&quot;:&quot;GEO&quot;,&quot;num_code&quot;:&quot;268&quot;,&quot;phone_code&quot;:&quot;995&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GEORGIA">GEORGIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:74,&quot;iso&quot;:&quot;DE&quot;,&quot;name&quot;:&quot;GERMANY&quot;,&quot;nick_name&quot;:&quot;Germany&quot;,&quot;iso3&quot;:&quot;DEU&quot;,&quot;num_code&quot;:&quot;276&quot;,&quot;phone_code&quot;:&quot;49&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GERMANY">GERMANY</option>
                                            <option
                                                data-country="{&quot;id&quot;:75,&quot;iso&quot;:&quot;GH&quot;,&quot;name&quot;:&quot;GHANA&quot;,&quot;nick_name&quot;:&quot;Ghana&quot;,&quot;iso3&quot;:&quot;GHA&quot;,&quot;num_code&quot;:&quot;288&quot;,&quot;phone_code&quot;:&quot;233&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GHANA">GHANA</option>
                                            <option
                                                data-country="{&quot;id&quot;:76,&quot;iso&quot;:&quot;GI&quot;,&quot;name&quot;:&quot;GIBRALTAR&quot;,&quot;nick_name&quot;:&quot;Gibraltar&quot;,&quot;iso3&quot;:&quot;GIB&quot;,&quot;num_code&quot;:&quot;292&quot;,&quot;phone_code&quot;:&quot;350&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GIBRALTAR">GIBRALTAR</option>
                                            <option
                                                data-country="{&quot;id&quot;:77,&quot;iso&quot;:&quot;GR&quot;,&quot;name&quot;:&quot;GREECE&quot;,&quot;nick_name&quot;:&quot;Greece&quot;,&quot;iso3&quot;:&quot;GRC&quot;,&quot;num_code&quot;:&quot;300&quot;,&quot;phone_code&quot;:&quot;30&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GREECE">GREECE</option>
                                            <option
                                                data-country="{&quot;id&quot;:78,&quot;iso&quot;:&quot;GL&quot;,&quot;name&quot;:&quot;GREENLAND&quot;,&quot;nick_name&quot;:&quot;Greenland&quot;,&quot;iso3&quot;:&quot;GRL&quot;,&quot;num_code&quot;:&quot;304&quot;,&quot;phone_code&quot;:&quot;299&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GREENLAND">GREENLAND</option>
                                            <option
                                                data-country="{&quot;id&quot;:79,&quot;iso&quot;:&quot;GD&quot;,&quot;name&quot;:&quot;GRENADA&quot;,&quot;nick_name&quot;:&quot;Grenada&quot;,&quot;iso3&quot;:&quot;GRD&quot;,&quot;num_code&quot;:&quot;308&quot;,&quot;phone_code&quot;:&quot;1473&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GRENADA">GRENADA</option>
                                            <option
                                                data-country="{&quot;id&quot;:80,&quot;iso&quot;:&quot;GP&quot;,&quot;name&quot;:&quot;GUADELOUPE&quot;,&quot;nick_name&quot;:&quot;Guadeloupe&quot;,&quot;iso3&quot;:&quot;GLP&quot;,&quot;num_code&quot;:&quot;312&quot;,&quot;phone_code&quot;:&quot;590&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GUADELOUPE">GUADELOUPE</option>
                                            <option
                                                data-country="{&quot;id&quot;:81,&quot;iso&quot;:&quot;GU&quot;,&quot;name&quot;:&quot;GUAM&quot;,&quot;nick_name&quot;:&quot;Guam&quot;,&quot;iso3&quot;:&quot;GUM&quot;,&quot;num_code&quot;:&quot;316&quot;,&quot;phone_code&quot;:&quot;1671&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GUAM">GUAM</option>
                                            <option
                                                data-country="{&quot;id&quot;:82,&quot;iso&quot;:&quot;GT&quot;,&quot;name&quot;:&quot;GUATEMALA&quot;,&quot;nick_name&quot;:&quot;Guatemala&quot;,&quot;iso3&quot;:&quot;GTM&quot;,&quot;num_code&quot;:&quot;320&quot;,&quot;phone_code&quot;:&quot;502&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GUATEMALA">GUATEMALA</option>
                                            <option
                                                data-country="{&quot;id&quot;:83,&quot;iso&quot;:&quot;GN&quot;,&quot;name&quot;:&quot;GUINEA&quot;,&quot;nick_name&quot;:&quot;Guinea&quot;,&quot;iso3&quot;:&quot;GIN&quot;,&quot;num_code&quot;:&quot;324&quot;,&quot;phone_code&quot;:&quot;224&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GUINEA">GUINEA</option>
                                            <option
                                                data-country="{&quot;id&quot;:84,&quot;iso&quot;:&quot;GW&quot;,&quot;name&quot;:&quot;GUINEA-BISSAU&quot;,&quot;nick_name&quot;:&quot;Guinea-Bissau&quot;,&quot;iso3&quot;:&quot;GNB&quot;,&quot;num_code&quot;:&quot;624&quot;,&quot;phone_code&quot;:&quot;245&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GUINEA-BISSAU">GUINEA-BISSAU</option>
                                            <option
                                                data-country="{&quot;id&quot;:85,&quot;iso&quot;:&quot;GY&quot;,&quot;name&quot;:&quot;GUYANA&quot;,&quot;nick_name&quot;:&quot;Guyana&quot;,&quot;iso3&quot;:&quot;GUY&quot;,&quot;num_code&quot;:&quot;328&quot;,&quot;phone_code&quot;:&quot;592&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="GUYANA">GUYANA</option>
                                            <option
                                                data-country="{&quot;id&quot;:86,&quot;iso&quot;:&quot;HT&quot;,&quot;name&quot;:&quot;HAITI&quot;,&quot;nick_name&quot;:&quot;Haiti&quot;,&quot;iso3&quot;:&quot;HTI&quot;,&quot;num_code&quot;:&quot;332&quot;,&quot;phone_code&quot;:&quot;509&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="HAITI">HAITI</option>
                                            <option
                                                data-country="{&quot;id&quot;:87,&quot;iso&quot;:&quot;VA&quot;,&quot;name&quot;:&quot;HOLY SEE (VATICAN CITY STATE)&quot;,&quot;nick_name&quot;:&quot;Holy See (Vatican City State)&quot;,&quot;iso3&quot;:&quot;VAT&quot;,&quot;num_code&quot;:&quot;336&quot;,&quot;phone_code&quot;:&quot;39&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="HOLY SEE (VATICAN CITY STATE)">HOLY SEE (VATICAN CITY STATE)
                                            </option>
                                            <option
                                                data-country="{&quot;id&quot;:88,&quot;iso&quot;:&quot;HN&quot;,&quot;name&quot;:&quot;HONDURAS&quot;,&quot;nick_name&quot;:&quot;Honduras&quot;,&quot;iso3&quot;:&quot;HND&quot;,&quot;num_code&quot;:&quot;340&quot;,&quot;phone_code&quot;:&quot;504&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="HONDURAS">HONDURAS</option>
                                            <option
                                                data-country="{&quot;id&quot;:89,&quot;iso&quot;:&quot;HK&quot;,&quot;name&quot;:&quot;HONG KONG&quot;,&quot;nick_name&quot;:&quot;Hong Kong&quot;,&quot;iso3&quot;:&quot;HKG&quot;,&quot;num_code&quot;:&quot;344&quot;,&quot;phone_code&quot;:&quot;852&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="HONG KONG">HONG KONG</option>
                                            <option
                                                data-country="{&quot;id&quot;:90,&quot;iso&quot;:&quot;HU&quot;,&quot;name&quot;:&quot;HUNGARY&quot;,&quot;nick_name&quot;:&quot;Hungary&quot;,&quot;iso3&quot;:&quot;HUN&quot;,&quot;num_code&quot;:&quot;348&quot;,&quot;phone_code&quot;:&quot;36&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="HUNGARY">HUNGARY</option>
                                            <option
                                                data-country="{&quot;id&quot;:91,&quot;iso&quot;:&quot;IS&quot;,&quot;name&quot;:&quot;ICELAND&quot;,&quot;nick_name&quot;:&quot;Iceland&quot;,&quot;iso3&quot;:&quot;ISL&quot;,&quot;num_code&quot;:&quot;352&quot;,&quot;phone_code&quot;:&quot;354&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ICELAND">ICELAND</option>
                                            <option
                                                data-country="{&quot;id&quot;:92,&quot;iso&quot;:&quot;IN&quot;,&quot;name&quot;:&quot;INDIA&quot;,&quot;nick_name&quot;:&quot;India&quot;,&quot;iso3&quot;:&quot;IND&quot;,&quot;num_code&quot;:&quot;356&quot;,&quot;phone_code&quot;:&quot;91&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="INDIA">INDIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:93,&quot;iso&quot;:&quot;ID&quot;,&quot;name&quot;:&quot;INDONESIA&quot;,&quot;nick_name&quot;:&quot;Indonesia&quot;,&quot;iso3&quot;:&quot;IDN&quot;,&quot;num_code&quot;:&quot;360&quot;,&quot;phone_code&quot;:&quot;62&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="INDONESIA">INDONESIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:94,&quot;iso&quot;:&quot;IR&quot;,&quot;name&quot;:&quot;IRAN, ISLAMIC REPUBLIC OF&quot;,&quot;nick_name&quot;:&quot;Iran, Islamic Republic of&quot;,&quot;iso3&quot;:&quot;IRN&quot;,&quot;num_code&quot;:&quot;364&quot;,&quot;phone_code&quot;:&quot;98&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="IRAN, ISLAMIC REPUBLIC OF">IRAN, ISLAMIC REPUBLIC OF</option>
                                            <option
                                                data-country="{&quot;id&quot;:95,&quot;iso&quot;:&quot;IQ&quot;,&quot;name&quot;:&quot;IRAQ&quot;,&quot;nick_name&quot;:&quot;Iraq&quot;,&quot;iso3&quot;:&quot;IRQ&quot;,&quot;num_code&quot;:&quot;368&quot;,&quot;phone_code&quot;:&quot;964&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="IRAQ">IRAQ</option>
                                            <option
                                                data-country="{&quot;id&quot;:96,&quot;iso&quot;:&quot;IE&quot;,&quot;name&quot;:&quot;IRELAND&quot;,&quot;nick_name&quot;:&quot;Ireland&quot;,&quot;iso3&quot;:&quot;IRL&quot;,&quot;num_code&quot;:&quot;372&quot;,&quot;phone_code&quot;:&quot;353&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="IRELAND">IRELAND</option>
                                            <option
                                                data-country="{&quot;id&quot;:97,&quot;iso&quot;:&quot;IL&quot;,&quot;name&quot;:&quot;ISRAEL&quot;,&quot;nick_name&quot;:&quot;Israel&quot;,&quot;iso3&quot;:&quot;ISR&quot;,&quot;num_code&quot;:&quot;376&quot;,&quot;phone_code&quot;:&quot;972&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ISRAEL">ISRAEL</option>
                                            <option
                                                data-country="{&quot;id&quot;:98,&quot;iso&quot;:&quot;IT&quot;,&quot;name&quot;:&quot;ITALY&quot;,&quot;nick_name&quot;:&quot;Italy&quot;,&quot;iso3&quot;:&quot;ITA&quot;,&quot;num_code&quot;:&quot;380&quot;,&quot;phone_code&quot;:&quot;39&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ITALY">ITALY</option>
                                            <option
                                                data-country="{&quot;id&quot;:99,&quot;iso&quot;:&quot;JM&quot;,&quot;name&quot;:&quot;JAMAICA&quot;,&quot;nick_name&quot;:&quot;Jamaica&quot;,&quot;iso3&quot;:&quot;JAM&quot;,&quot;num_code&quot;:&quot;388&quot;,&quot;phone_code&quot;:&quot;1876&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="JAMAICA">JAMAICA</option>
                                            <option
                                                data-country="{&quot;id&quot;:100,&quot;iso&quot;:&quot;JP&quot;,&quot;name&quot;:&quot;JAPAN&quot;,&quot;nick_name&quot;:&quot;Japan&quot;,&quot;iso3&quot;:&quot;JPN&quot;,&quot;num_code&quot;:&quot;392&quot;,&quot;phone_code&quot;:&quot;81&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="JAPAN">JAPAN</option>
                                            <option
                                                data-country="{&quot;id&quot;:101,&quot;iso&quot;:&quot;JO&quot;,&quot;name&quot;:&quot;JORDAN&quot;,&quot;nick_name&quot;:&quot;Jordan&quot;,&quot;iso3&quot;:&quot;JOR&quot;,&quot;num_code&quot;:&quot;400&quot;,&quot;phone_code&quot;:&quot;962&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="JORDAN">JORDAN</option>
                                            <option
                                                data-country="{&quot;id&quot;:102,&quot;iso&quot;:&quot;KZ&quot;,&quot;name&quot;:&quot;KAZAKHSTAN&quot;,&quot;nick_name&quot;:&quot;Kazakhstan&quot;,&quot;iso3&quot;:&quot;KAZ&quot;,&quot;num_code&quot;:&quot;398&quot;,&quot;phone_code&quot;:&quot;7&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="KAZAKHSTAN">KAZAKHSTAN</option>
                                            <option
                                                data-country="{&quot;id&quot;:103,&quot;iso&quot;:&quot;KE&quot;,&quot;name&quot;:&quot;KENYA&quot;,&quot;nick_name&quot;:&quot;Kenya&quot;,&quot;iso3&quot;:&quot;KEN&quot;,&quot;num_code&quot;:&quot;404&quot;,&quot;phone_code&quot;:&quot;254&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="KENYA">KENYA</option>
                                            <option
                                                data-country="{&quot;id&quot;:104,&quot;iso&quot;:&quot;KI&quot;,&quot;name&quot;:&quot;KIRIBATI&quot;,&quot;nick_name&quot;:&quot;Kiribati&quot;,&quot;iso3&quot;:&quot;KIR&quot;,&quot;num_code&quot;:&quot;296&quot;,&quot;phone_code&quot;:&quot;686&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="KIRIBATI">KIRIBATI</option>
                                            <option
                                                data-country="{&quot;id&quot;:105,&quot;iso&quot;:&quot;KP&quot;,&quot;name&quot;:&quot;KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF&quot;,&quot;nick_name&quot;:&quot;Korea, Democratic People's Republic of&quot;,&quot;iso3&quot;:&quot;PRK&quot;,&quot;num_code&quot;:&quot;408&quot;,&quot;phone_code&quot;:&quot;850&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF">KOREA, DEMOCRATIC
                                                PEOPLE'S REPUBLIC OF</option>
                                            <option
                                                data-country="{&quot;id&quot;:106,&quot;iso&quot;:&quot;KR&quot;,&quot;name&quot;:&quot;KOREA, REPUBLIC OF&quot;,&quot;nick_name&quot;:&quot;Korea, Republic of&quot;,&quot;iso3&quot;:&quot;KOR&quot;,&quot;num_code&quot;:&quot;410&quot;,&quot;phone_code&quot;:&quot;82&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="KOREA, REPUBLIC OF">KOREA, REPUBLIC OF</option>
                                            <option
                                                data-country="{&quot;id&quot;:107,&quot;iso&quot;:&quot;KW&quot;,&quot;name&quot;:&quot;KUWAIT&quot;,&quot;nick_name&quot;:&quot;Kuwait&quot;,&quot;iso3&quot;:&quot;KWT&quot;,&quot;num_code&quot;:&quot;414&quot;,&quot;phone_code&quot;:&quot;965&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="KUWAIT">KUWAIT</option>
                                            <option
                                                data-country="{&quot;id&quot;:108,&quot;iso&quot;:&quot;KG&quot;,&quot;name&quot;:&quot;KYRGYZSTAN&quot;,&quot;nick_name&quot;:&quot;Kyrgyzstan&quot;,&quot;iso3&quot;:&quot;KGZ&quot;,&quot;num_code&quot;:&quot;417&quot;,&quot;phone_code&quot;:&quot;996&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="KYRGYZSTAN">KYRGYZSTAN</option>
                                            <option
                                                data-country="{&quot;id&quot;:109,&quot;iso&quot;:&quot;LA&quot;,&quot;name&quot;:&quot;LAO PEOPLE'S DEMOCRATIC REPUBLIC&quot;,&quot;nick_name&quot;:&quot;Lao People's Democratic Republic&quot;,&quot;iso3&quot;:&quot;LAO&quot;,&quot;num_code&quot;:&quot;418&quot;,&quot;phone_code&quot;:&quot;856&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="LAO PEOPLE'S DEMOCRATIC REPUBLIC">LAO PEOPLE'S DEMOCRATIC
                                                REPUBLIC</option>
                                            <option
                                                data-country="{&quot;id&quot;:110,&quot;iso&quot;:&quot;LV&quot;,&quot;name&quot;:&quot;LATVIA&quot;,&quot;nick_name&quot;:&quot;Latvia&quot;,&quot;iso3&quot;:&quot;LVA&quot;,&quot;num_code&quot;:&quot;428&quot;,&quot;phone_code&quot;:&quot;371&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="LATVIA">LATVIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:111,&quot;iso&quot;:&quot;LB&quot;,&quot;name&quot;:&quot;LEBANON&quot;,&quot;nick_name&quot;:&quot;Lebanon&quot;,&quot;iso3&quot;:&quot;LBN&quot;,&quot;num_code&quot;:&quot;422&quot;,&quot;phone_code&quot;:&quot;961&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="LEBANON">LEBANON</option>
                                            <option
                                                data-country="{&quot;id&quot;:112,&quot;iso&quot;:&quot;LS&quot;,&quot;name&quot;:&quot;LESOTHO&quot;,&quot;nick_name&quot;:&quot;Lesotho&quot;,&quot;iso3&quot;:&quot;LSO&quot;,&quot;num_code&quot;:&quot;426&quot;,&quot;phone_code&quot;:&quot;266&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="LESOTHO">LESOTHO</option>
                                            <option
                                                data-country="{&quot;id&quot;:113,&quot;iso&quot;:&quot;LR&quot;,&quot;name&quot;:&quot;LIBERIA&quot;,&quot;nick_name&quot;:&quot;Liberia&quot;,&quot;iso3&quot;:&quot;LBR&quot;,&quot;num_code&quot;:&quot;430&quot;,&quot;phone_code&quot;:&quot;231&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="LIBERIA">LIBERIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:114,&quot;iso&quot;:&quot;LY&quot;,&quot;name&quot;:&quot;LIBYAN ARAB JAMAHIRIYA&quot;,&quot;nick_name&quot;:&quot;Libyan Arab Jamahiriya&quot;,&quot;iso3&quot;:&quot;LBY&quot;,&quot;num_code&quot;:&quot;434&quot;,&quot;phone_code&quot;:&quot;218&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="LIBYAN ARAB JAMAHIRIYA">LIBYAN ARAB JAMAHIRIYA</option>
                                            <option
                                                data-country="{&quot;id&quot;:115,&quot;iso&quot;:&quot;LI&quot;,&quot;name&quot;:&quot;LIECHTENSTEIN&quot;,&quot;nick_name&quot;:&quot;Liechtenstein&quot;,&quot;iso3&quot;:&quot;LIE&quot;,&quot;num_code&quot;:&quot;438&quot;,&quot;phone_code&quot;:&quot;423&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="LIECHTENSTEIN">LIECHTENSTEIN</option>
                                            <option
                                                data-country="{&quot;id&quot;:116,&quot;iso&quot;:&quot;LT&quot;,&quot;name&quot;:&quot;LITHUANIA&quot;,&quot;nick_name&quot;:&quot;Lithuania&quot;,&quot;iso3&quot;:&quot;LTU&quot;,&quot;num_code&quot;:&quot;440&quot;,&quot;phone_code&quot;:&quot;370&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="LITHUANIA">LITHUANIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:117,&quot;iso&quot;:&quot;LU&quot;,&quot;name&quot;:&quot;LUXEMBOURG&quot;,&quot;nick_name&quot;:&quot;Luxembourg&quot;,&quot;iso3&quot;:&quot;LUX&quot;,&quot;num_code&quot;:&quot;442&quot;,&quot;phone_code&quot;:&quot;352&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="LUXEMBOURG">LUXEMBOURG</option>
                                            <option
                                                data-country="{&quot;id&quot;:118,&quot;iso&quot;:&quot;MO&quot;,&quot;name&quot;:&quot;MACAO&quot;,&quot;nick_name&quot;:&quot;Macao&quot;,&quot;iso3&quot;:&quot;MAC&quot;,&quot;num_code&quot;:&quot;446&quot;,&quot;phone_code&quot;:&quot;853&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MACAO">MACAO</option>
                                            <option
                                                data-country="{&quot;id&quot;:119,&quot;iso&quot;:&quot;MK&quot;,&quot;name&quot;:&quot;MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF&quot;,&quot;nick_name&quot;:&quot;Macedonia, the Former Yugoslav Republic of&quot;,&quot;iso3&quot;:&quot;MKD&quot;,&quot;num_code&quot;:&quot;807&quot;,&quot;phone_code&quot;:&quot;389&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF">MACEDONIA, THE
                                                FORMER YUGOSLAV REPUBLIC OF</option>
                                            <option
                                                data-country="{&quot;id&quot;:120,&quot;iso&quot;:&quot;MG&quot;,&quot;name&quot;:&quot;MADAGASCAR&quot;,&quot;nick_name&quot;:&quot;Madagascar&quot;,&quot;iso3&quot;:&quot;MDG&quot;,&quot;num_code&quot;:&quot;450&quot;,&quot;phone_code&quot;:&quot;261&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MADAGASCAR">MADAGASCAR</option>
                                            <option
                                                data-country="{&quot;id&quot;:121,&quot;iso&quot;:&quot;MW&quot;,&quot;name&quot;:&quot;MALAWI&quot;,&quot;nick_name&quot;:&quot;Malawi&quot;,&quot;iso3&quot;:&quot;MWI&quot;,&quot;num_code&quot;:&quot;454&quot;,&quot;phone_code&quot;:&quot;265&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MALAWI">MALAWI</option>
                                            <option
                                                data-country="{&quot;id&quot;:122,&quot;iso&quot;:&quot;MY&quot;,&quot;name&quot;:&quot;MALAYSIA&quot;,&quot;nick_name&quot;:&quot;Malaysia&quot;,&quot;iso3&quot;:&quot;MYS&quot;,&quot;num_code&quot;:&quot;458&quot;,&quot;phone_code&quot;:&quot;60&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MALAYSIA">MALAYSIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:123,&quot;iso&quot;:&quot;MV&quot;,&quot;name&quot;:&quot;MALDIVES&quot;,&quot;nick_name&quot;:&quot;Maldives&quot;,&quot;iso3&quot;:&quot;MDV&quot;,&quot;num_code&quot;:&quot;462&quot;,&quot;phone_code&quot;:&quot;960&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MALDIVES">MALDIVES</option>
                                            <option
                                                data-country="{&quot;id&quot;:124,&quot;iso&quot;:&quot;ML&quot;,&quot;name&quot;:&quot;MALI&quot;,&quot;nick_name&quot;:&quot;Mali&quot;,&quot;iso3&quot;:&quot;MLI&quot;,&quot;num_code&quot;:&quot;466&quot;,&quot;phone_code&quot;:&quot;223&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MALI">MALI</option>
                                            <option
                                                data-country="{&quot;id&quot;:125,&quot;iso&quot;:&quot;MT&quot;,&quot;name&quot;:&quot;MALTA&quot;,&quot;nick_name&quot;:&quot;Malta&quot;,&quot;iso3&quot;:&quot;MLT&quot;,&quot;num_code&quot;:&quot;470&quot;,&quot;phone_code&quot;:&quot;356&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MALTA">MALTA</option>
                                            <option
                                                data-country="{&quot;id&quot;:126,&quot;iso&quot;:&quot;MH&quot;,&quot;name&quot;:&quot;MARSHALL ISLANDS&quot;,&quot;nick_name&quot;:&quot;Marshall Islands&quot;,&quot;iso3&quot;:&quot;MHL&quot;,&quot;num_code&quot;:&quot;584&quot;,&quot;phone_code&quot;:&quot;692&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MARSHALL ISLANDS">MARSHALL ISLANDS</option>
                                            <option
                                                data-country="{&quot;id&quot;:127,&quot;iso&quot;:&quot;MQ&quot;,&quot;name&quot;:&quot;MARTINIQUE&quot;,&quot;nick_name&quot;:&quot;Martinique&quot;,&quot;iso3&quot;:&quot;MTQ&quot;,&quot;num_code&quot;:&quot;474&quot;,&quot;phone_code&quot;:&quot;596&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MARTINIQUE">MARTINIQUE</option>
                                            <option
                                                data-country="{&quot;id&quot;:128,&quot;iso&quot;:&quot;MR&quot;,&quot;name&quot;:&quot;MAURITANIA&quot;,&quot;nick_name&quot;:&quot;Mauritania&quot;,&quot;iso3&quot;:&quot;MRT&quot;,&quot;num_code&quot;:&quot;478&quot;,&quot;phone_code&quot;:&quot;222&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MAURITANIA">MAURITANIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:129,&quot;iso&quot;:&quot;MU&quot;,&quot;name&quot;:&quot;MAURITIUS&quot;,&quot;nick_name&quot;:&quot;Mauritius&quot;,&quot;iso3&quot;:&quot;MUS&quot;,&quot;num_code&quot;:&quot;480&quot;,&quot;phone_code&quot;:&quot;230&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MAURITIUS">MAURITIUS</option>
                                            <option
                                                data-country="{&quot;id&quot;:130,&quot;iso&quot;:&quot;MX&quot;,&quot;name&quot;:&quot;MEXICO&quot;,&quot;nick_name&quot;:&quot;Mexico&quot;,&quot;iso3&quot;:&quot;MEX&quot;,&quot;num_code&quot;:&quot;484&quot;,&quot;phone_code&quot;:&quot;52&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MEXICO">MEXICO</option>
                                            <option
                                                data-country="{&quot;id&quot;:131,&quot;iso&quot;:&quot;FM&quot;,&quot;name&quot;:&quot;MICRONESIA, FEDERATED STATES OF&quot;,&quot;nick_name&quot;:&quot;Micronesia, Federated States of&quot;,&quot;iso3&quot;:&quot;FSM&quot;,&quot;num_code&quot;:&quot;583&quot;,&quot;phone_code&quot;:&quot;691&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MICRONESIA, FEDERATED STATES OF">MICRONESIA, FEDERATED STATES
                                                OF</option>
                                            <option
                                                data-country="{&quot;id&quot;:132,&quot;iso&quot;:&quot;MD&quot;,&quot;name&quot;:&quot;MOLDOVA, REPUBLIC OF&quot;,&quot;nick_name&quot;:&quot;Moldova, Republic of&quot;,&quot;iso3&quot;:&quot;MDA&quot;,&quot;num_code&quot;:&quot;498&quot;,&quot;phone_code&quot;:&quot;373&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MOLDOVA, REPUBLIC OF">MOLDOVA, REPUBLIC OF</option>
                                            <option
                                                data-country="{&quot;id&quot;:133,&quot;iso&quot;:&quot;MC&quot;,&quot;name&quot;:&quot;MONACO&quot;,&quot;nick_name&quot;:&quot;Monaco&quot;,&quot;iso3&quot;:&quot;MCO&quot;,&quot;num_code&quot;:&quot;492&quot;,&quot;phone_code&quot;:&quot;377&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MONACO">MONACO</option>
                                            <option
                                                data-country="{&quot;id&quot;:134,&quot;iso&quot;:&quot;MN&quot;,&quot;name&quot;:&quot;MONGOLIA&quot;,&quot;nick_name&quot;:&quot;Mongolia&quot;,&quot;iso3&quot;:&quot;MNG&quot;,&quot;num_code&quot;:&quot;496&quot;,&quot;phone_code&quot;:&quot;976&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MONGOLIA">MONGOLIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:135,&quot;iso&quot;:&quot;MS&quot;,&quot;name&quot;:&quot;MONTSERRAT&quot;,&quot;nick_name&quot;:&quot;Montserrat&quot;,&quot;iso3&quot;:&quot;MSR&quot;,&quot;num_code&quot;:&quot;500&quot;,&quot;phone_code&quot;:&quot;1664&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MONTSERRAT">MONTSERRAT</option>
                                            <option
                                                data-country="{&quot;id&quot;:136,&quot;iso&quot;:&quot;MA&quot;,&quot;name&quot;:&quot;MOROCCO&quot;,&quot;nick_name&quot;:&quot;Morocco&quot;,&quot;iso3&quot;:&quot;MAR&quot;,&quot;num_code&quot;:&quot;504&quot;,&quot;phone_code&quot;:&quot;212&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MOROCCO">MOROCCO</option>
                                            <option
                                                data-country="{&quot;id&quot;:137,&quot;iso&quot;:&quot;MZ&quot;,&quot;name&quot;:&quot;MOZAMBIQUE&quot;,&quot;nick_name&quot;:&quot;Mozambique&quot;,&quot;iso3&quot;:&quot;MOZ&quot;,&quot;num_code&quot;:&quot;508&quot;,&quot;phone_code&quot;:&quot;258&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MOZAMBIQUE">MOZAMBIQUE</option>
                                            <option
                                                data-country="{&quot;id&quot;:138,&quot;iso&quot;:&quot;MM&quot;,&quot;name&quot;:&quot;MYANMAR&quot;,&quot;nick_name&quot;:&quot;Myanmar&quot;,&quot;iso3&quot;:&quot;MMR&quot;,&quot;num_code&quot;:&quot;104&quot;,&quot;phone_code&quot;:&quot;95&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="MYANMAR">MYANMAR</option>
                                            <option
                                                data-country="{&quot;id&quot;:139,&quot;iso&quot;:&quot;NA&quot;,&quot;name&quot;:&quot;NAMIBIA&quot;,&quot;nick_name&quot;:&quot;Namibia&quot;,&quot;iso3&quot;:&quot;NAM&quot;,&quot;num_code&quot;:&quot;516&quot;,&quot;phone_code&quot;:&quot;264&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NAMIBIA">NAMIBIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:140,&quot;iso&quot;:&quot;NR&quot;,&quot;name&quot;:&quot;NAURU&quot;,&quot;nick_name&quot;:&quot;Nauru&quot;,&quot;iso3&quot;:&quot;NRU&quot;,&quot;num_code&quot;:&quot;520&quot;,&quot;phone_code&quot;:&quot;674&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NAURU">NAURU</option>
                                            <option
                                                data-country="{&quot;id&quot;:141,&quot;iso&quot;:&quot;NP&quot;,&quot;name&quot;:&quot;NEPAL&quot;,&quot;nick_name&quot;:&quot;Nepal&quot;,&quot;iso3&quot;:&quot;NPL&quot;,&quot;num_code&quot;:&quot;524&quot;,&quot;phone_code&quot;:&quot;977&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NEPAL">NEPAL</option>
                                            <option
                                                data-country="{&quot;id&quot;:142,&quot;iso&quot;:&quot;NL&quot;,&quot;name&quot;:&quot;NETHERLANDS&quot;,&quot;nick_name&quot;:&quot;Netherlands&quot;,&quot;iso3&quot;:&quot;NLD&quot;,&quot;num_code&quot;:&quot;528&quot;,&quot;phone_code&quot;:&quot;31&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NETHERLANDS">NETHERLANDS</option>
                                            <option
                                                data-country="{&quot;id&quot;:143,&quot;iso&quot;:&quot;AN&quot;,&quot;name&quot;:&quot;NETHERLANDS ANTILLES&quot;,&quot;nick_name&quot;:&quot;Netherlands Antilles&quot;,&quot;iso3&quot;:&quot;ANT&quot;,&quot;num_code&quot;:&quot;530&quot;,&quot;phone_code&quot;:&quot;599&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NETHERLANDS ANTILLES">NETHERLANDS ANTILLES</option>
                                            <option
                                                data-country="{&quot;id&quot;:144,&quot;iso&quot;:&quot;NC&quot;,&quot;name&quot;:&quot;NEW CALEDONIA&quot;,&quot;nick_name&quot;:&quot;New Caledonia&quot;,&quot;iso3&quot;:&quot;NCL&quot;,&quot;num_code&quot;:&quot;540&quot;,&quot;phone_code&quot;:&quot;687&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NEW CALEDONIA">NEW CALEDONIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:145,&quot;iso&quot;:&quot;NZ&quot;,&quot;name&quot;:&quot;NEW ZEALAND&quot;,&quot;nick_name&quot;:&quot;New Zealand&quot;,&quot;iso3&quot;:&quot;NZL&quot;,&quot;num_code&quot;:&quot;554&quot;,&quot;phone_code&quot;:&quot;64&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NEW ZEALAND">NEW ZEALAND</option>
                                            <option
                                                data-country="{&quot;id&quot;:146,&quot;iso&quot;:&quot;NI&quot;,&quot;name&quot;:&quot;NICARAGUA&quot;,&quot;nick_name&quot;:&quot;Nicaragua&quot;,&quot;iso3&quot;:&quot;NIC&quot;,&quot;num_code&quot;:&quot;558&quot;,&quot;phone_code&quot;:&quot;505&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NICARAGUA">NICARAGUA</option>
                                            <option
                                                data-country="{&quot;id&quot;:147,&quot;iso&quot;:&quot;NE&quot;,&quot;name&quot;:&quot;NIGER&quot;,&quot;nick_name&quot;:&quot;Niger&quot;,&quot;iso3&quot;:&quot;NER&quot;,&quot;num_code&quot;:&quot;562&quot;,&quot;phone_code&quot;:&quot;227&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NIGER">NIGER</option>
                                            <option
                                                data-country="{&quot;id&quot;:148,&quot;iso&quot;:&quot;NG&quot;,&quot;name&quot;:&quot;NIGERIA&quot;,&quot;nick_name&quot;:&quot;Nigeria&quot;,&quot;iso3&quot;:&quot;NGA&quot;,&quot;num_code&quot;:&quot;566&quot;,&quot;phone_code&quot;:&quot;234&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NIGERIA">NIGERIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:149,&quot;iso&quot;:&quot;NU&quot;,&quot;name&quot;:&quot;NIUE&quot;,&quot;nick_name&quot;:&quot;Niue&quot;,&quot;iso3&quot;:&quot;NIU&quot;,&quot;num_code&quot;:&quot;570&quot;,&quot;phone_code&quot;:&quot;683&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NIUE">NIUE</option>
                                            <option
                                                data-country="{&quot;id&quot;:150,&quot;iso&quot;:&quot;NF&quot;,&quot;name&quot;:&quot;NORFOLK ISLAND&quot;,&quot;nick_name&quot;:&quot;Norfolk Island&quot;,&quot;iso3&quot;:&quot;NFK&quot;,&quot;num_code&quot;:&quot;574&quot;,&quot;phone_code&quot;:&quot;672&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NORFOLK ISLAND">NORFOLK ISLAND</option>
                                            <option
                                                data-country="{&quot;id&quot;:151,&quot;iso&quot;:&quot;MP&quot;,&quot;name&quot;:&quot;NORTHERN MARIANA ISLANDS&quot;,&quot;nick_name&quot;:&quot;Northern Mariana Islands&quot;,&quot;iso3&quot;:&quot;MNP&quot;,&quot;num_code&quot;:&quot;580&quot;,&quot;phone_code&quot;:&quot;1670&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NORTHERN MARIANA ISLANDS">NORTHERN MARIANA ISLANDS</option>
                                            <option
                                                data-country="{&quot;id&quot;:152,&quot;iso&quot;:&quot;NO&quot;,&quot;name&quot;:&quot;NORWAY&quot;,&quot;nick_name&quot;:&quot;Norway&quot;,&quot;iso3&quot;:&quot;NOR&quot;,&quot;num_code&quot;:&quot;578&quot;,&quot;phone_code&quot;:&quot;47&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="NORWAY">NORWAY</option>
                                            <option
                                                data-country="{&quot;id&quot;:153,&quot;iso&quot;:&quot;OM&quot;,&quot;name&quot;:&quot;OMAN&quot;,&quot;nick_name&quot;:&quot;Oman&quot;,&quot;iso3&quot;:&quot;OMN&quot;,&quot;num_code&quot;:&quot;512&quot;,&quot;phone_code&quot;:&quot;968&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="OMAN">OMAN</option>
                                            <option
                                                data-country="{&quot;id&quot;:154,&quot;iso&quot;:&quot;PK&quot;,&quot;name&quot;:&quot;PAKISTAN&quot;,&quot;nick_name&quot;:&quot;Pakistan&quot;,&quot;iso3&quot;:&quot;PAK&quot;,&quot;num_code&quot;:&quot;586&quot;,&quot;phone_code&quot;:&quot;92&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="PAKISTAN">PAKISTAN</option>
                                            <option
                                                data-country="{&quot;id&quot;:155,&quot;iso&quot;:&quot;PW&quot;,&quot;name&quot;:&quot;PALAU&quot;,&quot;nick_name&quot;:&quot;Palau&quot;,&quot;iso3&quot;:&quot;PLW&quot;,&quot;num_code&quot;:&quot;585&quot;,&quot;phone_code&quot;:&quot;680&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="PALAU">PALAU</option>
                                            <option
                                                data-country="{&quot;id&quot;:156,&quot;iso&quot;:&quot;PA&quot;,&quot;name&quot;:&quot;PANAMA&quot;,&quot;nick_name&quot;:&quot;Panama&quot;,&quot;iso3&quot;:&quot;PAN&quot;,&quot;num_code&quot;:&quot;591&quot;,&quot;phone_code&quot;:&quot;507&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="PANAMA">PANAMA</option>
                                            <option
                                                data-country="{&quot;id&quot;:157,&quot;iso&quot;:&quot;PG&quot;,&quot;name&quot;:&quot;PAPUA NEW GUINEA&quot;,&quot;nick_name&quot;:&quot;Papua New Guinea&quot;,&quot;iso3&quot;:&quot;PNG&quot;,&quot;num_code&quot;:&quot;598&quot;,&quot;phone_code&quot;:&quot;675&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="PAPUA NEW GUINEA">PAPUA NEW GUINEA</option>
                                            <option
                                                data-country="{&quot;id&quot;:158,&quot;iso&quot;:&quot;PY&quot;,&quot;name&quot;:&quot;PARAGUAY&quot;,&quot;nick_name&quot;:&quot;Paraguay&quot;,&quot;iso3&quot;:&quot;PRY&quot;,&quot;num_code&quot;:&quot;600&quot;,&quot;phone_code&quot;:&quot;595&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="PARAGUAY">PARAGUAY</option>
                                            <option
                                                data-country="{&quot;id&quot;:159,&quot;iso&quot;:&quot;PE&quot;,&quot;name&quot;:&quot;PERU&quot;,&quot;nick_name&quot;:&quot;Peru&quot;,&quot;iso3&quot;:&quot;PER&quot;,&quot;num_code&quot;:&quot;604&quot;,&quot;phone_code&quot;:&quot;51&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="PERU">PERU</option>
                                            <option
                                                data-country="{&quot;id&quot;:160,&quot;iso&quot;:&quot;PH&quot;,&quot;name&quot;:&quot;PHILIPPINES&quot;,&quot;nick_name&quot;:&quot;Philippines&quot;,&quot;iso3&quot;:&quot;PHL&quot;,&quot;num_code&quot;:&quot;608&quot;,&quot;phone_code&quot;:&quot;63&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="PHILIPPINES">PHILIPPINES</option>
                                            <option
                                                data-country="{&quot;id&quot;:161,&quot;iso&quot;:&quot;PN&quot;,&quot;name&quot;:&quot;PITCAIRN&quot;,&quot;nick_name&quot;:&quot;Pitcairn&quot;,&quot;iso3&quot;:&quot;PCN&quot;,&quot;num_code&quot;:&quot;612&quot;,&quot;phone_code&quot;:&quot;0&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="PITCAIRN">PITCAIRN</option>
                                            <option
                                                data-country="{&quot;id&quot;:162,&quot;iso&quot;:&quot;PL&quot;,&quot;name&quot;:&quot;POLAND&quot;,&quot;nick_name&quot;:&quot;Poland&quot;,&quot;iso3&quot;:&quot;POL&quot;,&quot;num_code&quot;:&quot;616&quot;,&quot;phone_code&quot;:&quot;48&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="POLAND">POLAND</option>
                                            <option
                                                data-country="{&quot;id&quot;:163,&quot;iso&quot;:&quot;PT&quot;,&quot;name&quot;:&quot;PORTUGAL&quot;,&quot;nick_name&quot;:&quot;Portugal&quot;,&quot;iso3&quot;:&quot;PRT&quot;,&quot;num_code&quot;:&quot;620&quot;,&quot;phone_code&quot;:&quot;351&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="PORTUGAL">PORTUGAL</option>
                                            <option
                                                data-country="{&quot;id&quot;:164,&quot;iso&quot;:&quot;PR&quot;,&quot;name&quot;:&quot;PUERTO RICO&quot;,&quot;nick_name&quot;:&quot;Puerto Rico&quot;,&quot;iso3&quot;:&quot;PRI&quot;,&quot;num_code&quot;:&quot;630&quot;,&quot;phone_code&quot;:&quot;1787&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="PUERTO RICO">PUERTO RICO</option>
                                            <option
                                                data-country="{&quot;id&quot;:165,&quot;iso&quot;:&quot;QA&quot;,&quot;name&quot;:&quot;QATAR&quot;,&quot;nick_name&quot;:&quot;Qatar&quot;,&quot;iso3&quot;:&quot;QAT&quot;,&quot;num_code&quot;:&quot;634&quot;,&quot;phone_code&quot;:&quot;974&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="QATAR">QATAR</option>
                                            <option
                                                data-country="{&quot;id&quot;:166,&quot;iso&quot;:&quot;RE&quot;,&quot;name&quot;:&quot;REUNION&quot;,&quot;nick_name&quot;:&quot;Reunion&quot;,&quot;iso3&quot;:&quot;REU&quot;,&quot;num_code&quot;:&quot;638&quot;,&quot;phone_code&quot;:&quot;262&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="REUNION">REUNION</option>
                                            <option
                                                data-country="{&quot;id&quot;:167,&quot;iso&quot;:&quot;RO&quot;,&quot;name&quot;:&quot;ROMANIA&quot;,&quot;nick_name&quot;:&quot;Romania&quot;,&quot;iso3&quot;:&quot;ROM&quot;,&quot;num_code&quot;:&quot;642&quot;,&quot;phone_code&quot;:&quot;40&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ROMANIA">ROMANIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:168,&quot;iso&quot;:&quot;RU&quot;,&quot;name&quot;:&quot;RUSSIAN FEDERATION&quot;,&quot;nick_name&quot;:&quot;Russian Federation&quot;,&quot;iso3&quot;:&quot;RUS&quot;,&quot;num_code&quot;:&quot;643&quot;,&quot;phone_code&quot;:&quot;70&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="RUSSIAN FEDERATION">RUSSIAN FEDERATION</option>
                                            <option
                                                data-country="{&quot;id&quot;:169,&quot;iso&quot;:&quot;RW&quot;,&quot;name&quot;:&quot;RWANDA&quot;,&quot;nick_name&quot;:&quot;Rwanda&quot;,&quot;iso3&quot;:&quot;RWA&quot;,&quot;num_code&quot;:&quot;646&quot;,&quot;phone_code&quot;:&quot;250&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="RWANDA">RWANDA</option>
                                            <option
                                                data-country="{&quot;id&quot;:170,&quot;iso&quot;:&quot;SH&quot;,&quot;name&quot;:&quot;SAINT HELENA&quot;,&quot;nick_name&quot;:&quot;Saint Helena&quot;,&quot;iso3&quot;:&quot;SHN&quot;,&quot;num_code&quot;:&quot;654&quot;,&quot;phone_code&quot;:&quot;290&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SAINT HELENA">SAINT HELENA</option>
                                            <option
                                                data-country="{&quot;id&quot;:171,&quot;iso&quot;:&quot;KN&quot;,&quot;name&quot;:&quot;SAINT KITTS AND NEVIS&quot;,&quot;nick_name&quot;:&quot;Saint Kitts and Nevis&quot;,&quot;iso3&quot;:&quot;KNA&quot;,&quot;num_code&quot;:&quot;659&quot;,&quot;phone_code&quot;:&quot;1869&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SAINT KITTS AND NEVIS">SAINT KITTS AND NEVIS</option>
                                            <option
                                                data-country="{&quot;id&quot;:172,&quot;iso&quot;:&quot;LC&quot;,&quot;name&quot;:&quot;SAINT LUCIA&quot;,&quot;nick_name&quot;:&quot;Saint Lucia&quot;,&quot;iso3&quot;:&quot;LCA&quot;,&quot;num_code&quot;:&quot;662&quot;,&quot;phone_code&quot;:&quot;1758&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SAINT LUCIA">SAINT LUCIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:173,&quot;iso&quot;:&quot;PM&quot;,&quot;name&quot;:&quot;SAINT PIERRE AND MIQUELON&quot;,&quot;nick_name&quot;:&quot;Saint Pierre and Miquelon&quot;,&quot;iso3&quot;:&quot;SPM&quot;,&quot;num_code&quot;:&quot;666&quot;,&quot;phone_code&quot;:&quot;508&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SAINT PIERRE AND MIQUELON">SAINT PIERRE AND MIQUELON</option>
                                            <option
                                                data-country="{&quot;id&quot;:174,&quot;iso&quot;:&quot;VC&quot;,&quot;name&quot;:&quot;SAINT VINCENT AND THE GRENADINES&quot;,&quot;nick_name&quot;:&quot;Saint Vincent and the Grenadines&quot;,&quot;iso3&quot;:&quot;VCT&quot;,&quot;num_code&quot;:&quot;670&quot;,&quot;phone_code&quot;:&quot;1784&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SAINT VINCENT AND THE GRENADINES">SAINT VINCENT AND THE
                                                GRENADINES</option>
                                            <option
                                                data-country="{&quot;id&quot;:175,&quot;iso&quot;:&quot;WS&quot;,&quot;name&quot;:&quot;SAMOA&quot;,&quot;nick_name&quot;:&quot;Samoa&quot;,&quot;iso3&quot;:&quot;WSM&quot;,&quot;num_code&quot;:&quot;882&quot;,&quot;phone_code&quot;:&quot;684&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SAMOA">SAMOA</option>
                                            <option
                                                data-country="{&quot;id&quot;:176,&quot;iso&quot;:&quot;SM&quot;,&quot;name&quot;:&quot;SAN MARINO&quot;,&quot;nick_name&quot;:&quot;San Marino&quot;,&quot;iso3&quot;:&quot;SMR&quot;,&quot;num_code&quot;:&quot;674&quot;,&quot;phone_code&quot;:&quot;378&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SAN MARINO">SAN MARINO</option>
                                            <option
                                                data-country="{&quot;id&quot;:177,&quot;iso&quot;:&quot;ST&quot;,&quot;name&quot;:&quot;SAO TOME AND PRINCIPE&quot;,&quot;nick_name&quot;:&quot;Sao Tome and Principe&quot;,&quot;iso3&quot;:&quot;STP&quot;,&quot;num_code&quot;:&quot;678&quot;,&quot;phone_code&quot;:&quot;239&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SAO TOME AND PRINCIPE">SAO TOME AND PRINCIPE</option>
                                            <option
                                                data-country="{&quot;id&quot;:178,&quot;iso&quot;:&quot;SA&quot;,&quot;name&quot;:&quot;SAUDI ARABIA&quot;,&quot;nick_name&quot;:&quot;Saudi Arabia&quot;,&quot;iso3&quot;:&quot;SAU&quot;,&quot;num_code&quot;:&quot;682&quot;,&quot;phone_code&quot;:&quot;966&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SAUDI ARABIA">SAUDI ARABIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:179,&quot;iso&quot;:&quot;SN&quot;,&quot;name&quot;:&quot;SENEGAL&quot;,&quot;nick_name&quot;:&quot;Senegal&quot;,&quot;iso3&quot;:&quot;SEN&quot;,&quot;num_code&quot;:&quot;686&quot;,&quot;phone_code&quot;:&quot;221&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SENEGAL">SENEGAL</option>
                                            <option
                                                data-country="{&quot;id&quot;:180,&quot;iso&quot;:&quot;SC&quot;,&quot;name&quot;:&quot;SEYCHELLES&quot;,&quot;nick_name&quot;:&quot;Seychelles&quot;,&quot;iso3&quot;:&quot;SYC&quot;,&quot;num_code&quot;:&quot;690&quot;,&quot;phone_code&quot;:&quot;248&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SEYCHELLES">SEYCHELLES</option>
                                            <option
                                                data-country="{&quot;id&quot;:181,&quot;iso&quot;:&quot;SL&quot;,&quot;name&quot;:&quot;SIERRA LEONE&quot;,&quot;nick_name&quot;:&quot;Sierra Leone&quot;,&quot;iso3&quot;:&quot;SLE&quot;,&quot;num_code&quot;:&quot;694&quot;,&quot;phone_code&quot;:&quot;232&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SIERRA LEONE">SIERRA LEONE</option>
                                            <option
                                                data-country="{&quot;id&quot;:182,&quot;iso&quot;:&quot;SG&quot;,&quot;name&quot;:&quot;SINGAPORE&quot;,&quot;nick_name&quot;:&quot;Singapore&quot;,&quot;iso3&quot;:&quot;SGP&quot;,&quot;num_code&quot;:&quot;702&quot;,&quot;phone_code&quot;:&quot;65&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SINGAPORE">SINGAPORE</option>
                                            <option
                                                data-country="{&quot;id&quot;:183,&quot;iso&quot;:&quot;SK&quot;,&quot;name&quot;:&quot;SLOVAKIA&quot;,&quot;nick_name&quot;:&quot;Slovakia&quot;,&quot;iso3&quot;:&quot;SVK&quot;,&quot;num_code&quot;:&quot;703&quot;,&quot;phone_code&quot;:&quot;421&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SLOVAKIA">SLOVAKIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:184,&quot;iso&quot;:&quot;SI&quot;,&quot;name&quot;:&quot;SLOVENIA&quot;,&quot;nick_name&quot;:&quot;Slovenia&quot;,&quot;iso3&quot;:&quot;SVN&quot;,&quot;num_code&quot;:&quot;705&quot;,&quot;phone_code&quot;:&quot;386&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SLOVENIA">SLOVENIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:185,&quot;iso&quot;:&quot;SB&quot;,&quot;name&quot;:&quot;SOLOMON ISLANDS&quot;,&quot;nick_name&quot;:&quot;Solomon Islands&quot;,&quot;iso3&quot;:&quot;SLB&quot;,&quot;num_code&quot;:&quot;90&quot;,&quot;phone_code&quot;:&quot;677&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SOLOMON ISLANDS">SOLOMON ISLANDS</option>
                                            <option
                                                data-country="{&quot;id&quot;:186,&quot;iso&quot;:&quot;SO&quot;,&quot;name&quot;:&quot;SOMALIA&quot;,&quot;nick_name&quot;:&quot;Somalia&quot;,&quot;iso3&quot;:&quot;SOM&quot;,&quot;num_code&quot;:&quot;706&quot;,&quot;phone_code&quot;:&quot;252&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SOMALIA">SOMALIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:187,&quot;iso&quot;:&quot;ZA&quot;,&quot;name&quot;:&quot;SOUTH AFRICA&quot;,&quot;nick_name&quot;:&quot;South Africa&quot;,&quot;iso3&quot;:&quot;ZAF&quot;,&quot;num_code&quot;:&quot;710&quot;,&quot;phone_code&quot;:&quot;27&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SOUTH AFRICA">SOUTH AFRICA</option>
                                            <option
                                                data-country="{&quot;id&quot;:188,&quot;iso&quot;:&quot;ES&quot;,&quot;name&quot;:&quot;SPAIN&quot;,&quot;nick_name&quot;:&quot;Spain&quot;,&quot;iso3&quot;:&quot;ESP&quot;,&quot;num_code&quot;:&quot;724&quot;,&quot;phone_code&quot;:&quot;34&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SPAIN">SPAIN</option>
                                            <option
                                                data-country="{&quot;id&quot;:189,&quot;iso&quot;:&quot;LK&quot;,&quot;name&quot;:&quot;SRI LANKA&quot;,&quot;nick_name&quot;:&quot;Sri Lanka&quot;,&quot;iso3&quot;:&quot;LKA&quot;,&quot;num_code&quot;:&quot;144&quot;,&quot;phone_code&quot;:&quot;94&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SRI LANKA">SRI LANKA</option>
                                            <option
                                                data-country="{&quot;id&quot;:190,&quot;iso&quot;:&quot;SD&quot;,&quot;name&quot;:&quot;SUDAN&quot;,&quot;nick_name&quot;:&quot;Sudan&quot;,&quot;iso3&quot;:&quot;SDN&quot;,&quot;num_code&quot;:&quot;736&quot;,&quot;phone_code&quot;:&quot;249&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SUDAN">SUDAN</option>
                                            <option
                                                data-country="{&quot;id&quot;:191,&quot;iso&quot;:&quot;SR&quot;,&quot;name&quot;:&quot;SURINAME&quot;,&quot;nick_name&quot;:&quot;Suriname&quot;,&quot;iso3&quot;:&quot;SUR&quot;,&quot;num_code&quot;:&quot;740&quot;,&quot;phone_code&quot;:&quot;597&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SURINAME">SURINAME</option>
                                            <option
                                                data-country="{&quot;id&quot;:192,&quot;iso&quot;:&quot;SJ&quot;,&quot;name&quot;:&quot;SVALBARD AND JAN MAYEN&quot;,&quot;nick_name&quot;:&quot;Svalbard and Jan Mayen&quot;,&quot;iso3&quot;:&quot;SJM&quot;,&quot;num_code&quot;:&quot;744&quot;,&quot;phone_code&quot;:&quot;47&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SVALBARD AND JAN MAYEN">SVALBARD AND JAN MAYEN</option>
                                            <option
                                                data-country="{&quot;id&quot;:193,&quot;iso&quot;:&quot;SZ&quot;,&quot;name&quot;:&quot;SWAZILAND&quot;,&quot;nick_name&quot;:&quot;Swaziland&quot;,&quot;iso3&quot;:&quot;SWZ&quot;,&quot;num_code&quot;:&quot;748&quot;,&quot;phone_code&quot;:&quot;268&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SWAZILAND">SWAZILAND</option>
                                            <option
                                                data-country="{&quot;id&quot;:194,&quot;iso&quot;:&quot;SE&quot;,&quot;name&quot;:&quot;SWEDEN&quot;,&quot;nick_name&quot;:&quot;Sweden&quot;,&quot;iso3&quot;:&quot;SWE&quot;,&quot;num_code&quot;:&quot;752&quot;,&quot;phone_code&quot;:&quot;46&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SWEDEN">SWEDEN</option>
                                            <option
                                                data-country="{&quot;id&quot;:195,&quot;iso&quot;:&quot;CH&quot;,&quot;name&quot;:&quot;SWITZERLAND&quot;,&quot;nick_name&quot;:&quot;Switzerland&quot;,&quot;iso3&quot;:&quot;CHE&quot;,&quot;num_code&quot;:&quot;756&quot;,&quot;phone_code&quot;:&quot;41&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SWITZERLAND">SWITZERLAND</option>
                                            <option
                                                data-country="{&quot;id&quot;:196,&quot;iso&quot;:&quot;SY&quot;,&quot;name&quot;:&quot;SYRIAN ARAB REPUBLIC&quot;,&quot;nick_name&quot;:&quot;Syrian Arab Republic&quot;,&quot;iso3&quot;:&quot;SYR&quot;,&quot;num_code&quot;:&quot;760&quot;,&quot;phone_code&quot;:&quot;963&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="SYRIAN ARAB REPUBLIC">SYRIAN ARAB REPUBLIC</option>
                                            <option
                                                data-country="{&quot;id&quot;:197,&quot;iso&quot;:&quot;TW&quot;,&quot;name&quot;:&quot;TAIWAN, PROVINCE OF CHINA&quot;,&quot;nick_name&quot;:&quot;Taiwan, Province of China&quot;,&quot;iso3&quot;:&quot;TWN&quot;,&quot;num_code&quot;:&quot;158&quot;,&quot;phone_code&quot;:&quot;886&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="TAIWAN, PROVINCE OF CHINA">TAIWAN, PROVINCE OF CHINA</option>
                                            <option
                                                data-country="{&quot;id&quot;:198,&quot;iso&quot;:&quot;TJ&quot;,&quot;name&quot;:&quot;TAJIKISTAN&quot;,&quot;nick_name&quot;:&quot;Tajikistan&quot;,&quot;iso3&quot;:&quot;TJK&quot;,&quot;num_code&quot;:&quot;762&quot;,&quot;phone_code&quot;:&quot;992&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="TAJIKISTAN">TAJIKISTAN</option>
                                            <option
                                                data-country="{&quot;id&quot;:199,&quot;iso&quot;:&quot;TZ&quot;,&quot;name&quot;:&quot;TANZANIA, UNITED REPUBLIC OF&quot;,&quot;nick_name&quot;:&quot;Tanzania, United Republic of&quot;,&quot;iso3&quot;:&quot;TZA&quot;,&quot;num_code&quot;:&quot;834&quot;,&quot;phone_code&quot;:&quot;255&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="TANZANIA, UNITED REPUBLIC OF">TANZANIA, UNITED REPUBLIC OF
                                            </option>
                                            <option
                                                data-country="{&quot;id&quot;:200,&quot;iso&quot;:&quot;TH&quot;,&quot;name&quot;:&quot;THAILAND&quot;,&quot;nick_name&quot;:&quot;Thailand&quot;,&quot;iso3&quot;:&quot;THA&quot;,&quot;num_code&quot;:&quot;764&quot;,&quot;phone_code&quot;:&quot;66&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="THAILAND">THAILAND</option>
                                            <option
                                                data-country="{&quot;id&quot;:201,&quot;iso&quot;:&quot;TG&quot;,&quot;name&quot;:&quot;TOGO&quot;,&quot;nick_name&quot;:&quot;Togo&quot;,&quot;iso3&quot;:&quot;TGO&quot;,&quot;num_code&quot;:&quot;768&quot;,&quot;phone_code&quot;:&quot;228&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="TOGO">TOGO</option>
                                            <option
                                                data-country="{&quot;id&quot;:202,&quot;iso&quot;:&quot;TK&quot;,&quot;name&quot;:&quot;TOKELAU&quot;,&quot;nick_name&quot;:&quot;Tokelau&quot;,&quot;iso3&quot;:&quot;TKL&quot;,&quot;num_code&quot;:&quot;772&quot;,&quot;phone_code&quot;:&quot;690&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="TOKELAU">TOKELAU</option>
                                            <option
                                                data-country="{&quot;id&quot;:203,&quot;iso&quot;:&quot;TO&quot;,&quot;name&quot;:&quot;TONGA&quot;,&quot;nick_name&quot;:&quot;Tonga&quot;,&quot;iso3&quot;:&quot;TON&quot;,&quot;num_code&quot;:&quot;776&quot;,&quot;phone_code&quot;:&quot;676&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="TONGA">TONGA</option>
                                            <option
                                                data-country="{&quot;id&quot;:204,&quot;iso&quot;:&quot;TT&quot;,&quot;name&quot;:&quot;TRINIDAD AND TOBAGO&quot;,&quot;nick_name&quot;:&quot;Trinidad and Tobago&quot;,&quot;iso3&quot;:&quot;TTO&quot;,&quot;num_code&quot;:&quot;780&quot;,&quot;phone_code&quot;:&quot;1868&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="TRINIDAD AND TOBAGO">TRINIDAD AND TOBAGO</option>
                                            <option
                                                data-country="{&quot;id&quot;:205,&quot;iso&quot;:&quot;TN&quot;,&quot;name&quot;:&quot;TUNISIA&quot;,&quot;nick_name&quot;:&quot;Tunisia&quot;,&quot;iso3&quot;:&quot;TUN&quot;,&quot;num_code&quot;:&quot;788&quot;,&quot;phone_code&quot;:&quot;216&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="TUNISIA">TUNISIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:206,&quot;iso&quot;:&quot;TR&quot;,&quot;name&quot;:&quot;TURKEY&quot;,&quot;nick_name&quot;:&quot;Turkey&quot;,&quot;iso3&quot;:&quot;TUR&quot;,&quot;num_code&quot;:&quot;792&quot;,&quot;phone_code&quot;:&quot;90&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="TURKEY">TURKEY</option>
                                            <option
                                                data-country="{&quot;id&quot;:207,&quot;iso&quot;:&quot;TM&quot;,&quot;name&quot;:&quot;TURKMENISTAN&quot;,&quot;nick_name&quot;:&quot;Turkmenistan&quot;,&quot;iso3&quot;:&quot;TKM&quot;,&quot;num_code&quot;:&quot;795&quot;,&quot;phone_code&quot;:&quot;7370&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="TURKMENISTAN">TURKMENISTAN</option>
                                            <option
                                                data-country="{&quot;id&quot;:208,&quot;iso&quot;:&quot;TC&quot;,&quot;name&quot;:&quot;TURKS AND CAICOS ISLANDS&quot;,&quot;nick_name&quot;:&quot;Turks and Caicos Islands&quot;,&quot;iso3&quot;:&quot;TCA&quot;,&quot;num_code&quot;:&quot;796&quot;,&quot;phone_code&quot;:&quot;1649&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="TURKS AND CAICOS ISLANDS">TURKS AND CAICOS ISLANDS</option>
                                            <option
                                                data-country="{&quot;id&quot;:209,&quot;iso&quot;:&quot;TV&quot;,&quot;name&quot;:&quot;TUVALU&quot;,&quot;nick_name&quot;:&quot;Tuvalu&quot;,&quot;iso3&quot;:&quot;TUV&quot;,&quot;num_code&quot;:&quot;798&quot;,&quot;phone_code&quot;:&quot;688&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="TUVALU">TUVALU</option>
                                            <option
                                                data-country="{&quot;id&quot;:210,&quot;iso&quot;:&quot;UG&quot;,&quot;name&quot;:&quot;UGANDA&quot;,&quot;nick_name&quot;:&quot;Uganda&quot;,&quot;iso3&quot;:&quot;UGA&quot;,&quot;num_code&quot;:&quot;800&quot;,&quot;phone_code&quot;:&quot;256&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="UGANDA">UGANDA</option>
                                            <option
                                                data-country="{&quot;id&quot;:211,&quot;iso&quot;:&quot;UA&quot;,&quot;name&quot;:&quot;UKRAINE&quot;,&quot;nick_name&quot;:&quot;Ukraine&quot;,&quot;iso3&quot;:&quot;UKR&quot;,&quot;num_code&quot;:&quot;804&quot;,&quot;phone_code&quot;:&quot;380&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="UKRAINE">UKRAINE</option>
                                            <option
                                                data-country="{&quot;id&quot;:212,&quot;iso&quot;:&quot;AE&quot;,&quot;name&quot;:&quot;UNITED ARAB EMIRATES&quot;,&quot;nick_name&quot;:&quot;United Arab Emirates&quot;,&quot;iso3&quot;:&quot;ARE&quot;,&quot;num_code&quot;:&quot;784&quot;,&quot;phone_code&quot;:&quot;971&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="UNITED ARAB EMIRATES">UNITED ARAB EMIRATES</option>
                                            <option
                                                data-country="{&quot;id&quot;:213,&quot;iso&quot;:&quot;GB&quot;,&quot;name&quot;:&quot;UNITED KINGDOM&quot;,&quot;nick_name&quot;:&quot;United Kingdom&quot;,&quot;iso3&quot;:&quot;GBR&quot;,&quot;num_code&quot;:&quot;826&quot;,&quot;phone_code&quot;:&quot;44&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="UNITED KINGDOM">UNITED KINGDOM</option>
                                            <option
                                                data-country="{&quot;id&quot;:214,&quot;iso&quot;:&quot;US&quot;,&quot;name&quot;:&quot;UNITED STATES&quot;,&quot;nick_name&quot;:&quot;United States&quot;,&quot;iso3&quot;:&quot;USA&quot;,&quot;num_code&quot;:&quot;840&quot;,&quot;phone_code&quot;:&quot;1&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="UNITED STATES">UNITED STATES</option>
                                            <option
                                                data-country="{&quot;id&quot;:215,&quot;iso&quot;:&quot;UY&quot;,&quot;name&quot;:&quot;URUGUAY&quot;,&quot;nick_name&quot;:&quot;Uruguay&quot;,&quot;iso3&quot;:&quot;URY&quot;,&quot;num_code&quot;:&quot;858&quot;,&quot;phone_code&quot;:&quot;598&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="URUGUAY">URUGUAY</option>
                                            <option
                                                data-country="{&quot;id&quot;:216,&quot;iso&quot;:&quot;UZ&quot;,&quot;name&quot;:&quot;UZBEKISTAN&quot;,&quot;nick_name&quot;:&quot;Uzbekistan&quot;,&quot;iso3&quot;:&quot;UZB&quot;,&quot;num_code&quot;:&quot;860&quot;,&quot;phone_code&quot;:&quot;998&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="UZBEKISTAN">UZBEKISTAN</option>
                                            <option
                                                data-country="{&quot;id&quot;:217,&quot;iso&quot;:&quot;VU&quot;,&quot;name&quot;:&quot;VANUATU&quot;,&quot;nick_name&quot;:&quot;Vanuatu&quot;,&quot;iso3&quot;:&quot;VUT&quot;,&quot;num_code&quot;:&quot;548&quot;,&quot;phone_code&quot;:&quot;678&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="VANUATU">VANUATU</option>
                                            <option
                                                data-country="{&quot;id&quot;:218,&quot;iso&quot;:&quot;VE&quot;,&quot;name&quot;:&quot;VENEZUELA&quot;,&quot;nick_name&quot;:&quot;Venezuela&quot;,&quot;iso3&quot;:&quot;VEN&quot;,&quot;num_code&quot;:&quot;862&quot;,&quot;phone_code&quot;:&quot;58&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="VENEZUELA">VENEZUELA</option>
                                            <option
                                                data-country="{&quot;id&quot;:219,&quot;iso&quot;:&quot;VN&quot;,&quot;name&quot;:&quot;VIET NAM&quot;,&quot;nick_name&quot;:&quot;Viet Nam&quot;,&quot;iso3&quot;:&quot;VNM&quot;,&quot;num_code&quot;:&quot;704&quot;,&quot;phone_code&quot;:&quot;84&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="VIET NAM">VIET NAM</option>
                                            <option
                                                data-country="{&quot;id&quot;:220,&quot;iso&quot;:&quot;VG&quot;,&quot;name&quot;:&quot;VIRGIN ISLANDS, BRITISH&quot;,&quot;nick_name&quot;:&quot;Virgin Islands, British&quot;,&quot;iso3&quot;:&quot;VGB&quot;,&quot;num_code&quot;:&quot;92&quot;,&quot;phone_code&quot;:&quot;1284&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="VIRGIN ISLANDS, BRITISH">VIRGIN ISLANDS, BRITISH</option>
                                            <option
                                                data-country="{&quot;id&quot;:221,&quot;iso&quot;:&quot;VI&quot;,&quot;name&quot;:&quot;VIRGIN ISLANDS, U.S.&quot;,&quot;nick_name&quot;:&quot;Virgin Islands, U.s.&quot;,&quot;iso3&quot;:&quot;VIR&quot;,&quot;num_code&quot;:&quot;850&quot;,&quot;phone_code&quot;:&quot;1340&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="VIRGIN ISLANDS, U.S.">VIRGIN ISLANDS, U.S.</option>
                                            <option
                                                data-country="{&quot;id&quot;:222,&quot;iso&quot;:&quot;WF&quot;,&quot;name&quot;:&quot;WALLIS AND FUTUNA&quot;,&quot;nick_name&quot;:&quot;Wallis and Futuna&quot;,&quot;iso3&quot;:&quot;WLF&quot;,&quot;num_code&quot;:&quot;876&quot;,&quot;phone_code&quot;:&quot;681&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="WALLIS AND FUTUNA">WALLIS AND FUTUNA</option>
                                            <option
                                                data-country="{&quot;id&quot;:223,&quot;iso&quot;:&quot;EH&quot;,&quot;name&quot;:&quot;WESTERN SAHARA&quot;,&quot;nick_name&quot;:&quot;Western Sahara&quot;,&quot;iso3&quot;:&quot;ESH&quot;,&quot;num_code&quot;:&quot;732&quot;,&quot;phone_code&quot;:&quot;212&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="WESTERN SAHARA">WESTERN SAHARA</option>
                                            <option
                                                data-country="{&quot;id&quot;:224,&quot;iso&quot;:&quot;YE&quot;,&quot;name&quot;:&quot;YEMEN&quot;,&quot;nick_name&quot;:&quot;Yemen&quot;,&quot;iso3&quot;:&quot;YEM&quot;,&quot;num_code&quot;:&quot;887&quot;,&quot;phone_code&quot;:&quot;967&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="YEMEN">YEMEN</option>
                                            <option
                                                data-country="{&quot;id&quot;:225,&quot;iso&quot;:&quot;ZM&quot;,&quot;name&quot;:&quot;ZAMBIA&quot;,&quot;nick_name&quot;:&quot;Zambia&quot;,&quot;iso3&quot;:&quot;ZMB&quot;,&quot;num_code&quot;:&quot;894&quot;,&quot;phone_code&quot;:&quot;260&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ZAMBIA">ZAMBIA</option>
                                            <option
                                                data-country="{&quot;id&quot;:226,&quot;iso&quot;:&quot;ZW&quot;,&quot;name&quot;:&quot;ZIMBABWE&quot;,&quot;nick_name&quot;:&quot;Zimbabwe&quot;,&quot;iso3&quot;:&quot;ZWE&quot;,&quot;num_code&quot;:&quot;716&quot;,&quot;phone_code&quot;:&quot;26&quot;,&quot;created_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-06-18T11:12:25.000000Z&quot;}"
                                                value="ZIMBABWE">ZIMBABWE</option>
                                        </select>
                                        <span class="invalid-feedback" data-field="country"></span>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label" for="password">Password</label>
                                        <input class="form-control" type="password" name="password" id="password"
                                            placeholder="Enter your password">
                                        <span class="invalid-feedback" data-field="password"></span>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label" for="confirm">Confirm Password</label>
                                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation"
                                            placeholder="Re-enter your password">
                                        <span class="invalid-feedback" data-field="password_confirmation"></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <button id="registerSubmitBtn" class="btn btn-dark" type="submit">Register Now</button>
                                    </div>
                                    <center class="pt-2">
                                        <a class="text-decoration-underline h5" href="{{ route('frontend.login') }}">Already have
                                            account</a>
                                    </center>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- login-form end -->
    </div>
</main>
<!-- main content end -->
@endsection
@push('scripts')
<script>
$(function() {
    // CSRF header (Laravel)
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    $('#registerForm').on('submit', function(e) {
        e.preventDefault();

        const $form = $(this);
        const $btn  = $('#registerSubmitBtn');
        const redirectUrl = @json(route('index')); // safe JSON-encoded fallback

        clearFieldErrors($form);
        $btn.prop('disabled', true).text('Please wait...');

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            dataType: 'json'
        })
        .done(function(resp) {
            if (resp.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Registered!',
                    text: resp.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = resp.redirect || redirectUrl;
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Hmm...',
                    text: 'Unexpected response from server.'
                });
            }
        })
        .fail(function(xhr) {
            if (xhr.status === 422) {
                const json   = xhr.responseJSON || {};
                const errors = json.errors || {};

                // Mark fields inline
                showFieldErrors($form, errors);

                // Build a simple error message for SweetAlert
                const firstError = Object.values(errors).flat()[0] || 'Please fix the highlighted fields and try again.';

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: firstError
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong. Please try again later.'
                });
            }
        })
        .always(function(){
            $btn.prop('disabled', false).text('Register Now');
        });
    });

    function clearFieldErrors($form) {
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.invalid-feedback').text('');
    }

    function showFieldErrors($form, errors) {
        $.each(errors, function(field, messages) {
            const $input    = $form.find('[name="' + field + '"]');
            const $feedback = $form.find('.invalid-feedback[data-field="' + field + '"]');
            if ($input.length) { $input.addClass('is-invalid'); }
            if ($feedback.length) { $feedback.text(messages.join(' ')); }
        });
    }
});
</script>
@endpush
