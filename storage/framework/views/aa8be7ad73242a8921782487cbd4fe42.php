<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> 
        User Responses
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title py-1"><i class="fa fa-table"></i>
                                <?php if(request()->get('status') == 'archived'): ?>
                                    Archived
                                <?php endif; ?> User Responses
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Response</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        <?php if(request()->get('status') == 'archived'): ?>
                                            Archived
                                        <?php endif; ?> User Responses
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if(request()->get('status') != 'archived'): ?>
                                <a href="<?php echo e(url('/user_responses?status=archived')); ?>">Archived User Responses</a>
                            <?php else: ?>
                                <a href="<?php echo e(url('/user_responses')); ?>">User Responses</a>
                            <?php endif; ?>
                            <?php if(request()->get('status') == 'archived' && $user_responses->total() > 0): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.restore')): ?>
                                    <div class="float-end">
                                        <a href="" class="btn btn-primary btn-sm btn-restore-all"
                                            onclick="event.preventDefault(); restoreAllConfirmation()"><i
                                                class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                        <form id="restore-all-form" action="<?php echo e(route('user_responses.restore-all')); ?>"
                                            style="display:inline" method="POST">
                                            <?php echo method_field('POST'); ?>
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body mt-0 pt-0">
                    <div class="">
                        <form action="" method="GET">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="status"
                                value="<?php echo e(request()->get('status') == 'archived' ? 'archived' : ''); ?>">
                            <div class="row">

                                <div class="col-md-12 col-sm-12 px-0">
                                    <div class="input-group my-1">
                                        <select name="search_division" class="form-select" id="drpDivision">
                                            <option value="">select division</option>
                                            <option value="Dhaka">Dhaka</option>
                                            <option value="Chattogram">Chattogram</option>
                                            <option value="Barishal">Barishal</option>
                                            <option value="Khulna">Khulna</option>
                                            <option value="Mymensingh">Mymensingh</option>
                                            <option value="Rajshahi">Rajshahi</option>
                                            <option value="Rangpur">Rangpur</option>
                                            <option value="Sylhet">Sylhet</option>
                                        </select>
                                        <select name="search_district" class="form-select" id="drpDistrict">
                                            <option value="">select division first</option>
                                            <option data-link="Dhaka" value="Dhaka">Dhaka</option>
                                            <option data-link="Dhaka" value="Faridpur">Faridpur</option>
                                            <option data-link="Dhaka" value="Gazipur">Gazipur</option>
                                            <option data-link="Dhaka" value="Gopalganj">Gopalganj</option>
                                            <option data-link="Dhaka" value="Kishoreganj">Kishoreganj</option>
                                            <option data-link="Dhaka" value="Madaripur">Madaripur</option>
                                            <option data-link="Dhaka" value="Manikganj">Manikganj</option>
                                            <option data-link="Dhaka" value="Munshiganj">Munshiganj</option>
                                            <option data-link="Dhaka" value="Narayanganj">Narayanganj</option>
                                            <option data-link="Dhaka" value="Narsingdi">Narsingdi</option>
                                            <option data-link="Dhaka" value="Rajbari">Rajbari</option>
                                            <option data-link="Dhaka" value="Shariatpur">Shariatpur</option>
                                            <option data-link="Dhaka" value="Tangail">Tangail</option>
                                            <option data-link="Chattogram" value="Bandarban">Bandarban</option>
                                            <option data-link="Chattogram" value="Brahmanbaria">Brahmanbaria</option>
                                            <option data-link="Chattogram" value="Chandpur">Chandpur</option>
                                            <option data-link="Chattogram" value="Chittagong">Chittagong</option>
                                            <option data-link="Chattogram" value="Cumilla">Cumilla</option>
                                            <option data-link="Chattogram" value="Coxsbazar">Coxsbazar</option>
                                            <option data-link="Chattogram" value="Feni">Feni</option>
                                            <option data-link="Chattogram" value="Khagrachari">Khagrachari</option>
                                            <option data-link="Chattogram" value="Lakshmipur">Lakshmipur</option>
                                            <option data-link="Chattogram" value="Noakhali">Noakhali</option>
                                            <option data-link="Chattogram" value="Rangamati">Rangamati</option>
                                            <option data-link="Barishal" value="Barishal">Barishal</option>
                                            <option data-link="Barishal" value="Barguna">Barguna</option>
                                            <option data-link="Barishal" value="Bhola">Bhola</option>
                                            <option data-link="Barishal" value="Jhalakathi">Jhalakathi</option>
                                            <option data-link="Barishal" value="Patuakhali">Patuakhali</option>
                                            <option data-link="Barishal" value="Pirojpur">Pirojpur</option>
                                            <option data-link="Khulna" value="Bagerhat">Bagerhat</option>
                                            <option data-link="Khulna" value="Chuadanga">Chuadanga</option>
                                            <option data-link="Khulna" value="Jashore">Jashore</option>
                                            <option data-link="Khulna" value="Jhenaidah">Jhenaidah</option>
                                            <option data-link="Khulna" value="Khulna">Khulna</option>
                                            <option data-link="Khulna" value="Kushtia">Kushtia</option>
                                            <option data-link="Khulna" value="Magura">Magura</option>
                                            <option data-link="Khulna" value="Meherpur">Meherpur</option>
                                            <option data-link="Khulna" value="Narail">Narail</option>
                                            <option data-link="Khulna" value="Satkhira">Satkhira</option>
                                            <option data-link="Mymensingh" value="Mymensingh">Mymensingh</option>
                                            <option data-link="Mymensingh" value="Jamalpur">Jamalpur</option>
                                            <option data-link="Mymensingh" value="Sherpur">Sherpur</option>
                                            <option data-link="Mymensingh" value="Netrokona">Netrokona</option>
                                            <option data-link="Rajshahi" value="Bogura">Bogura</option>
                                            <option data-link="Rajshahi" value="Joypurhat">Joypurhat</option>
                                            <option data-link="Rajshahi" value="Naogaon">Naogaon</option>
                                            <option data-link="Rajshahi" value="Natore">Natore</option>
                                            <option data-link="Rajshahi" value="Chapainawabganj">Chapainawabganj
                                            </option>
                                            <option data-link="Rajshahi" value="Pabna">Pabna</option>
                                            <option data-link="Rajshahi" value="Rajshahi">Rajshahi</option>
                                            <option data-link="Rajshahi" value="Sirajganj">Sirajganj</option>
                                            <option data-link="Rangpur" value="Rangpur">Rangpur</option>
                                            <option data-link="Rangpur" value="Nilphamari">Nilphamari</option>
                                            <option data-link="Rangpur" value="Dinajpur">Dinajpur</option>
                                            <option data-link="Rangpur" value="Panchagarh">Panchagarh</option>
                                            <option data-link="Rangpur" value="Gaibandha">Gaibandha</option>
                                            <option data-link="Rangpur" value="Kurigram">Kurigram</option>
                                            <option data-link="Rangpur" value="Lalmonirhat">Lalmonirhat</option>
                                            <option data-link="Rangpur" value="Thakurgaon">Thakurgaon</option>
                                            <option data-link="Sylhet" value="Habiganj">Habiganj</option>
                                            <option data-link="Sylhet" value="Moulvibazar">Moulvibazar</option>
                                            <option data-link="Sylhet" value="Sunamganj">Sunamganj</option>
                                            <option data-link="Sylhet" value="Sylhet">Sylhet</option>
                                        </select>
                                        <select name="search_thana" class="form-select" id="drpUpazilla">
                                            <option value="">select district first</option>
                                            <option data-link="Dhaka" value="Dhamrai">Dhamrai</option>
                                            <option data-link="Dhaka" value="Dohar">Dohar</option>
                                            <option data-link="Dhaka" value="Keraniganj">Keraniganj</option>
                                            <option data-link="Dhaka" value="Nawabganj">Nawabganj</option>
                                            <option data-link="Dhaka" value="Savar">Savar</option>
                                            <option data-link="Dhaka" value="Tejgaoncircle">Tejgaoncircle</option>
                                            <option data-link="Faridpur" value="Faridpur Sadar">Faridpur Sadar
                                            </option>
                                            <option data-link="Faridpur" value="Bhanga Sadar">Bhanga Sadar</option>
                                            <option data-link="Faridpur" value="Madhukhali">Madhukhali</option>
                                            <option data-link="Faridpur" value="Sadarpur">Sadarpur</option>
                                            <option data-link="Faridpur" value="Alfadanga">Alfadanga</option>
                                            <option data-link="Faridpur" value="Boalmari">Boalmari</option>
                                            <option data-link="Faridpur" value="Charbhadrasan">Charbhadrasan</option>
                                            <option data-link="Faridpur" value="Nagarkanda">Nagarkanda</option>
                                            <option data-link="Faridpur" value="Shaltha">Shaltha</option>
                                            <option data-link="Gazipur" value="Gazipur Sadar">Gazipur Sadar</option>
                                            <option data-link="Gazipur" value="Kapasia">Kapasia</option>
                                            <option data-link="Gazipur" value="Tongi">Tongi</option>
                                            <option data-link="Gazipur" value="Sreepur">Sreepur</option>
                                            <option data-link="Gazipur" value="Kaliganj">Kaliganj</option>
                                            <option data-link="Gazipur" value="Kaliakior">Kaliakior</option>
                                            <option data-link="Gopalganj" value="Gopalganj Sadar">Gopalganj Sadar
                                            </option>
                                            <option data-link="Gopalganj" value="Tungipara">Tungipara</option>
                                            <option data-link="Gopalganj" value="Kotalipara">Kotalipara</option>
                                            <option data-link="Gopalganj" value="Kashiani">Kashiani</option>
                                            <option data-link="Gopalganj" value="Muksudpur">Muksudpur</option>
                                            <option data-link="Kishoreganj" value="Kishoreganj Sadar">Kishoreganj
                                                Sadar
                                            </option>
                                            <option data-link="Kishoreganj" value="Bhairab">Bhairab</option>
                                            <option data-link="Kishoreganj" value="Bajitpur">Bajitpur</option>
                                            <option data-link="Kishoreganj" value="Kuliarchar">Kuliarchar</option>
                                            <option data-link="Kishoreganj" value="Pakundia">Pakundia</option>
                                            <option data-link="Kishoreganj" value="Itna">Itna</option>
                                            <option data-link="Kishoreganj" value="Karimganj">Karimganj</option>
                                            <option data-link="Kishoreganj" value="Katiadi">Katiadi</option>
                                            <option data-link="Kishoreganj" value="Austagram">Austagram</option>
                                            <option data-link="Kishoreganj" value="Mithamain">Mithamain</option>
                                            <option data-link="Kishoreganj" value="Tarail">Tarail</option>
                                            <option data-link="Kishoreganj" value="Hossainpur">Hossainpur</option>
                                            <option data-link="Kishoreganj" value="Nikli">Nikli</option>
                                            <option data-link="Madaripur" value="Madaripur Sadar">Madaripur Sadar
                                            </option>
                                            <option data-link="Madaripur" value="Shibchar">Shibchar</option>
                                            <option data-link="Madaripur" value="Kalkini">Kalkini</option>
                                            <option data-link="Madaripur" value="Rajoir">Rajoir</option>
                                            <option data-link="Madaripur" value="Dasar">Dasar</option>
                                            <option data-link="Manikganj" value="Manikganj Sadar">Manikganj Sadar
                                            </option>
                                            <option data-link="Manikganj" value="Singiar">Singiar</option>
                                            <option data-link="Manikganj" value="Daulatpur">Daulatpur</option>
                                            <option data-link="Manikganj" value="Saturia">Saturia</option>
                                            <option data-link="Manikganj" value="Gior">Gior</option>
                                            <option data-link="Manikganj" value="Shibaloy">Shibaloy</option>
                                            <option data-link="Manikganj" value="Harirampur">Harirampur</option>
                                            <option data-link="Munshiganj" value="Munshiganj Sadar">Munshiganj Sadar
                                            </option>
                                            <option data-link="Munshiganj" value="Sreenagar">Sreenagar</option>
                                            <option data-link="Munshiganj" value="Lohajang">Lohajang</option>
                                            <option data-link="Munshiganj" value="Sirajdikhan">Sirajdikhan</option>
                                            <option data-link="Munshiganj" value="Gazaria">Gazaria</option>
                                            <option data-link="Munshiganj" value="Tongibari">Tongibari</option>
                                            <option data-link="Narayanganj" value="Narayanganj Sadar">Narayanganj
                                                Sadar
                                            </option>
                                            <option data-link="Narayanganj" value="Araihazar">Araihazar</option>
                                            <option data-link="Narayanganj" value="Rupganj">Rupganj</option>
                                            <option data-link="Narayanganj" value="Bandar">Bandar</option>
                                            <option data-link="Narayanganj" value="Sonargaon">Sonargaon</option>
                                            <option data-link="Narayanganj" value="Siddhirganj">Siddhirganj</option>
                                            <option data-link="Narayanganj" value="Fatullah">Fatullah</option>
                                            <option data-link="Narsingdi" value="Narsingdi Sadar">Narsingdi Sadar
                                            </option>
                                            <option data-link="Narsingdi" value="Monohardi">Monohardi</option>
                                            <option data-link="Narsingdi" value="Belabo">Belabo</option>
                                            <option data-link="Narsingdi" value="Raipura">Raipura</option>
                                            <option data-link="Narsingdi" value="Shibpur">Shibpur</option>
                                            <option data-link="Narsingdi" value="Palash">Palash</option>
                                            <option data-link="Rajbari" value="Rajbari Sadar">Rajbari Sadar</option>
                                            <option data-link="Rajbari" value="Baliakandi">Baliakandi</option>
                                            <option data-link="Rajbari" value="Kalukhali">Kalukhali</option>
                                            <option data-link="Rajbari" value="Goalanda">Goalanda</option>
                                            <option data-link="Rajbari" value="Pangsha">Pangsha</option>
                                            <option data-link="Shariatpur" value="Shariatpur Sadar">Shariatpur Sadar
                                            </option>
                                            <option data-link="Shariatpur" value="Bhedarganj">Bhedarganj</option>
                                            <option data-link="Shariatpur" value="Damudya">Damudya</option>
                                            <option data-link="Shariatpur" value="Gosairhat">Gosairhat</option>
                                            <option data-link="Shariatpur" value="Naria">Naria</option>
                                            <option data-link="Shariatpur" value="Shakhipur">Shakhipur</option>
                                            <option data-link="Shariatpur" value="Zajira">Zajira</option>
                                            <option data-link="Tangail" value="Tangail Sadar">Tangail Sadar</option>
                                            <option data-link="Tangail" value="Basail">Basail</option>
                                            <option data-link="Tangail" value="Bhuapur">Bhuapur</option>
                                            <option data-link="Tangail" value="Delduar">Delduar</option>
                                            <option data-link="Tangail" value="Dhanbari">Dhanbari</option>
                                            <option data-link="Tangail" value="Ghatail">Ghatail</option>
                                            <option data-link="Tangail" value="Gopalpur">Gopalpur</option>
                                            <option data-link="Tangail" value="Kalihati">Kalihati</option>
                                            <option data-link="Tangail" value="Madhupur">Madhupur</option>
                                            <option data-link="Tangail" value="Mirzapur">Mirzapur</option>
                                            <option data-link="Tangail" value="Nagarpur">Nagarpur</option>
                                            <option data-link="Tangail" value="Sakhipur">Sakhipur</option>
                                            <option data-link="Bandarban" value="Bandarban Sadar">Bandarban Sadar
                                            </option>
                                            <option data-link="Bandarban" value="Lama">Lama</option>
                                            <option data-link="Bandarban" value="Thanchi">Thanchi</option>
                                            <option data-link="Bandarban" value="Alikadam">Alikadam</option>
                                            <option data-link="Bandarban" value="Ruma">Ruma</option>
                                            <option data-link="Bandarban" value="Naikhongchhari">Naikhongchhari
                                            </option>
                                            <option data-link="Bandarban" value="Rowangcchari">Rowangcchari</option>
                                            <option data-link="Brahmanbaria" value="Brahmanbaria(B.Baria) Sadar">
                                                Brahmanbaria(B.Baria) Sadar</option>
                                            <option data-link="Brahmanbaria" value="Bijoynagar">Bijoynagar</option>
                                            <option data-link="Brahmanbaria" value="Akhaura">Akhaura</option>
                                            <option data-link="Brahmanbaria" value="Ashuganj">Ashuganj</option>
                                            <option data-link="Brahmanbaria" value="Bancharampur">Bancharampur
                                            </option>
                                            <option data-link="Brahmanbaria" value="Kasba">Kasba</option>
                                            <option data-link="Brahmanbaria" value="Nabinagar">Nabinagar</option>
                                            <option data-link="Brahmanbaria" value="Nasirnagar">Nasirnagar</option>
                                            <option data-link="Brahmanbaria" value="Sarail">Sarail</option>
                                            <option data-link="Chandpur" value="Chandpur Sadar">Chandpur Sadar
                                            </option>
                                            <option data-link="Chandpur" value="Haziganj">Haziganj</option>
                                            <option data-link="Chandpur" value="Shahrasti">Shahrasti</option>
                                            <option data-link="Chandpur" value="Haimchar">Haimchar</option>
                                            <option data-link="Chandpur" value="Faridganj">Faridganj</option>
                                            <option data-link="Chandpur" value="Kachua">Kachua</option>
                                            <option data-link="Chandpur" value="Matlab Uttar">Matlab Uttar</option>
                                            <option data-link="Chandpur" value="Matlab Dakkhin">Matlab Dakkhin
                                            </option>
                                            <option data-link="Chittagong" value="Mirsharai">Mirsharai</option>
                                            <option data-link="Chittagong" value="Rangunia">Rangunia</option>
                                            <option data-link="Chittagong" value="Patiya">Patiya</option>
                                            <option data-link="Chittagong" value="Raozan">Raozan</option>
                                            <option data-link="Chittagong" value="Sandwip">Sandwip</option>
                                            <option data-link="Chittagong" value="Satkania">Satkania</option>
                                            <option data-link="Chittagong" value="Sitakunda">Sitakunda</option>
                                            <option data-link="Chittagong" value="Anwara">Anwara</option>
                                            <option data-link="Chittagong" value="Banshkhali">Banshkhali</option>
                                            <option data-link="Chittagong" value="Boalkhali">Boalkhali</option>
                                            <option data-link="Chittagong" value="Chandanaish">Chandanaish</option>
                                            <option data-link="Chittagong" value="Fatikchhari">Fatikchhari</option>
                                            <option data-link="Chittagong" value="Hathazari">Hathazari</option>
                                            <option data-link="Chittagong" value="Lohagara">Lohagara</option>
                                            <option data-link="Chittagong" value="Karnafuli">Karnafuli</option>
                                            <option data-link="Cumilla" value="Cumilla Sadar South">Cumilla Sadar
                                                South
                                            </option>
                                            <option data-link="Cumilla" value="Cumilla Adarsa Sadar">Cumilla Adarsa
                                                Sadar
                                            </option>
                                            <option data-link="Cumilla" value="Barura">Barura</option>
                                            <option data-link="Cumilla" value="Chandina">Chandina</option>
                                            <option data-link="Cumilla" value="Chauddagram">Chauddagram</option>
                                            <option data-link="Cumilla" value="Daudkandi">Daudkandi</option>
                                            <option data-link="Cumilla" value="Brahmanpara">Brahmanpara</option>
                                            <option data-link="Cumilla" value="Homna">Homna</option>
                                            <option data-link="Cumilla" value="Monohorgonj">Monohorgonj</option>
                                            <option data-link="Cumilla" value="Laksam">Laksam</option>
                                            <option data-link="Cumilla" value="Debidwar">Debidwar</option>
                                            <option data-link="Cumilla" value="Meghna">Meghna</option>
                                            <option data-link="Cumilla" value="Muradnagar">Muradnagar</option>
                                            <option data-link="Cumilla" value="Nangalkot">Nangalkot</option>
                                            <option data-link="Cumilla" value="Burichong">Burichong</option>
                                            <option data-link="Cumilla" value="Titas">Titas</option>
                                            <option data-link="Cumilla" value="Lalmai">Lalmai</option>
                                            <option data-link="Coxsbazar" value="Coxsbazar Sadar">Coxsbazar Sadar
                                            </option>
                                            <option data-link="Coxsbazar" value="Teknaf">Teknaf</option>
                                            <option data-link="Coxsbazar" value="Chakaria">Chakaria</option>
                                            <option data-link="Coxsbazar" value="Maheshkhali">Maheshkhali</option>
                                            <option data-link="Coxsbazar" value="Pekua">Pekua</option>
                                            <option data-link="Coxsbazar" value="Kutubdia">Kutubdia</option>
                                            <option data-link="Coxsbazar" value="Ukhia">Ukhia</option>
                                            <option data-link="Coxsbazar" value="Ramu">Ramu</option>
                                            <option data-link="Feni" value="Feni Sadar">Feni Sadar</option>
                                            <option data-link="Feni" value="Daganbhuiyan">Daganbhuiyan</option>
                                            <option data-link="Feni" value="Chhagalnaiya">Chhagalnaiya</option>
                                            <option data-link="Feni" value="Porshuram">Porshuram</option>
                                            <option data-link="Feni" value="Fulgazi">Fulgazi</option>
                                            <option data-link="Feni" value="Sonagazi">Sonagazi</option>
                                            <option data-link="Khagrachari" value="Khagrachhari Sadar">Khagrachhari
                                                Sadar
                                            </option>
                                            <option data-link="Khagrachari" value="Panchhari">Panchhari</option>
                                            <option data-link="Khagrachari" value="Dighinala">Dighinala</option>
                                            <option data-link="Khagrachari" value="Manikchhari">Manikchhari</option>
                                            <option data-link="Khagrachari" value="Lakshmichhari">Lakshmichhari
                                            </option>
                                            <option data-link="Khagrachari" value="Ramgarh">Ramgarh</option>
                                            <option data-link="Khagrachari" value="Mahalchhari">Mahalchhari</option>
                                            <option data-link="Khagrachari" value="Matiranga">Matiranga</option>
                                            <option data-link="Khagrachari" value="Guimara">Guimara</option>
                                            <option data-link="Lakshmipur" value="Lakshmipur (Laxmipur) Sadar">
                                                Lakshmipur
                                                (Laxmipur) Sadar</option>
                                            <option data-link="Lakshmipur" value="Ramgati">Ramgati</option>
                                            <option data-link="Lakshmipur" value="Komolnagar">Komolnagar</option>
                                            <option data-link="Lakshmipur" value="Raipur">Raipur</option>
                                            <option data-link="Lakshmipur" value="Ramganj">Ramganj</option>
                                            <option data-link="Noakhali" value="Noakhali Sadar">Noakhali Sadar
                                            </option>
                                            <option data-link="Noakhali" value="Begumganj">Begumganj</option>
                                            <option data-link="Noakhali" value="Senbag">Senbag</option>
                                            <option data-link="Noakhali" value="Companiganj">Companiganj</option>
                                            <option data-link="Noakhali" value="Chatkhil">Chatkhil</option>
                                            <option data-link="Noakhali" value="Sonaimuri">Sonaimuri</option>
                                            <option data-link="Noakhali" value="Hatiya">Hatiya</option>
                                            <option data-link="Noakhali" value="Subarnachar">Subarnachar</option>
                                            <option data-link="Noakhali" value="Kabirhat">Kabirhat</option>
                                            <option data-link="Rangamati" value="Rangamati Sadar">Rangamati Sadar
                                            </option>
                                            <option data-link="Rangamati" value="Kaptai">Kaptai</option>
                                            <option data-link="Rangamati" value="Kaukhali">Kaukhali</option>
                                            <option data-link="Rangamati" value="Nannerchar">Nannerchar</option>
                                            <option data-link="Rangamati" value="Bagaichhari">Bagaichhari</option>
                                            <option data-link="Rangamati" value="Juraichhari">Juraichhari</option>
                                            <option data-link="Rangamati" value="Rajasthali">Rajasthali</option>
                                            <option data-link="Rangamati" value="Belaichhari">Belaichhari</option>
                                            <option data-link="Rangamati" value="Barkal">Barkal</option>
                                            <option data-link="Rangamati" value="Langadu">Langadu</option>
                                            <option data-link="Barishal" value="Barishal Sadar">Barishal Sadar
                                            </option>
                                            <option data-link="Barishal" value="Banaripara">Banaripara</option>
                                            <option data-link="Barishal" value="Bakerganj">Bakerganj</option>
                                            <option data-link="Barishal" value="Babuganj">Babuganj</option>
                                            <option data-link="Barishal" value="Gaurnadi">Gaurnadi</option>
                                            <option data-link="Barishal" value="Hizla">Hizla</option>
                                            <option data-link="Barishal" value="Mehendiganj">Mehendiganj</option>
                                            <option data-link="Barishal" value="Agailjhara">Agailjhara</option>
                                            <option data-link="Barishal" value="Wazirpur">Wazirpur</option>
                                            <option data-link="Barishal" value="Muladi">Muladi</option>
                                            <option data-link="Barguna" value="Barguna Sadar">Barguna Sadar</option>
                                            <option data-link="Barguna" value="Betagi">Betagi</option>
                                            <option data-link="Barguna" value="Bamna">Bamna</option>
                                            <option data-link="Barguna" value="Patharghata">Patharghata</option>
                                            <option data-link="Barguna" value="Amtali">Amtali</option>
                                            <option data-link="Barguna" value="Taltali">Taltali</option>
                                            <option data-link="Bhola" value="Bhola Sadar">Bhola Sadar</option>
                                            <option data-link="Bhola" value="Charfesson">Charfesson</option>
                                            <option data-link="Bhola" value="Manpura">Manpura</option>
                                            <option data-link="Bhola" value="Burhanuddin">Burhanuddin</option>
                                            <option data-link="Bhola" value="Tazumuddin">Tazumuddin</option>
                                            <option data-link="Bhola" value="Daulatkhan">Daulatkhan</option>
                                            <option data-link="Bhola" value="Lalmohan">Lalmohan</option>
                                            <option data-link="Jhalakathi" value="Jhalakathi Sadar">Jhalakathi Sadar
                                            </option>
                                            <option data-link="Jhalakathi" value="Nalchity">Nalchity</option>
                                            <option data-link="Jhalakathi" value="Kathalia">Kathalia</option>
                                            <option data-link="Jhalakathi" value="Rajapur">Rajapur</option>
                                            <option data-link="Patuakhali" value="Patuakhali Sadar">Patuakhali Sadar
                                            </option>
                                            <option data-link="Patuakhali" value="Galachipa">Galachipa</option>
                                            <option data-link="Patuakhali" value="Dumki">Dumki</option>
                                            <option data-link="Patuakhali" value="Mirzaganj">Mirzaganj</option>
                                            <option data-link="Patuakhali" value="Dasmina">Dasmina</option>
                                            <option data-link="Patuakhali" value="Bauphal">Bauphal</option>
                                            <option data-link="Patuakhali" value="Kalapara">Kalapara</option>
                                            <option data-link="Patuakhali" value="Rangabali">Rangabali</option>
                                            <option data-link="Pirojpur" value="Pirojpur Sadar">Pirojpur Sadar
                                            </option>
                                            <option data-link="Pirojpur" value="Indurkani">Indurkani</option>
                                            <option data-link="Pirojpur" value="Mathbaria">Mathbaria</option>
                                            <option data-link="Pirojpur" value="Bhandaria">Bhandaria</option>
                                            <option data-link="Pirojpur" value="Kawkhali">Kawkhali</option>
                                            <option data-link="Pirojpur" value="Nesarabad (Swarupkathi)">Nesarabad
                                                (Swarupkathi)</option>
                                            <option data-link="Pirojpur" value="Nazirpur">Nazirpur</option>
                                            <option data-link="Bagerhat" value="Bagerhat Sadar">Bagerhat Sadar
                                            </option>
                                            <option data-link="Bagerhat" value="Mongla">Mongla</option>
                                            <option data-link="Bagerhat" value="Chitalmari">Chitalmari</option>
                                            <option data-link="Bagerhat" value="Mollahat">Mollahat</option>
                                            <option data-link="Bagerhat" value="Sarankhola">Sarankhola</option>
                                            <option data-link="Bagerhat" value="Rampal">Rampal</option>
                                            <option data-link="Bagerhat" value="Fakirhat">Fakirhat</option>
                                            <option data-link="Bagerhat" value="Morrelganj">Morrelganj</option>
                                            <option data-link="Bagerhat" value="Kachua">Kachua</option>
                                            <option data-link="Chuadanga" value="Chuadanga Sadar">Chuadanga Sadar
                                            </option>
                                            <option data-link="Chuadanga" value="Alamdanga">Alamdanga</option>
                                            <option data-link="Chuadanga" value="Damurhuda">Damurhuda</option>
                                            <option data-link="Chuadanga" value="Jibannagar">Jibannagar</option>
                                            <option data-link="Jashore" value="Jashore Sadar">Jashore Sadar</option>
                                            <option data-link="Jashore" value="Jhikargachha">Jhikargachha</option>
                                            <option data-link="Jashore" value="Manirampur">Manirampur</option>
                                            <option data-link="Jashore" value="Bagherpara">Bagherpara</option>
                                            <option data-link="Jashore" value="Abhaynagar">Abhaynagar</option>
                                            <option data-link="Jashore" value="Keshabpur">Keshabpur</option>
                                            <option data-link="Jashore" value="Sharsha">Sharsha</option>
                                            <option data-link="Jashore" value="Chaugachha">Chaugachha</option>
                                            <option data-link="Jhenaidah" value="Jhenaidah Sadar">Jhenaidah Sadar
                                            </option>
                                            <option data-link="Jhenaidah" value="Shailkupa">Shailkupa</option>
                                            <option data-link="Jhenaidah" value="Harinakunda">Harinakunda</option>
                                            <option data-link="Jhenaidah" value="Maheshpur">Maheshpur</option>
                                            <option data-link="Jhenaidah" value="Kotchandpur">Kotchandpur</option>
                                            <option data-link="Jhenaidah" value="Kaliganj">Kaliganj</option>
                                            <option data-link="Khulna" value="Dumuria">Dumuria</option>
                                            <option data-link="Khulna" value="Batiaghata">Batiaghata</option>
                                            <option data-link="Khulna" value="Dakop">Dakop</option>
                                            <option data-link="Khulna" value="Fultola">Fultola</option>
                                            <option data-link="Khulna" value="Digholia">Digholia</option>
                                            <option data-link="Khulna" value="Koyra">Koyra</option>
                                            <option data-link="Khulna" value="Terokhada">Terokhada</option>
                                            <option data-link="Khulna" value="Rupsha">Rupsha</option>
                                            <option data-link="Khulna" value="Paikgasa">Paikgasa</option>
                                            <option data-link="Kushtia" value="Kushtia">Kushtia Sadar</option>
                                            <option data-link="Kushtia" value="Mirpur">Mirpur</option>
                                            <option data-link="Kushtia" value="Khoksa">Khoksa</option>
                                            <option data-link="Kushtia" value="Bheramara">Bheramara</option>
                                            <option data-link="Kushtia" value="Kumarkhali">Kumarkhali</option>
                                            <option data-link="Kushtia" value="Daulatpur">Daulatpur</option>
                                            <option data-link="Magura" value="Magura Sadar">Magura Sadar</option>
                                            <option data-link="Magura" value="Shalikha">Shalikha</option>
                                            <option data-link="Magura" value="Sreepur">Sreepur</option>
                                            <option data-link="Magura" value="Mohammadpur">Mohammadpur</option>
                                            <option data-link="Meherpur" value="Meherpur Sadar">Meherpur Sadar
                                            </option>
                                            <option data-link="Meherpur" value="Mujibnagar">Mujibnagar</option>
                                            <option data-link="Meherpur" value="Gangni">Gangni</option>
                                            <option data-link="Narail" value="Narail Sadar">Narail Sadar</option>
                                            <option data-link="Narail" value="Lohagara">Lohagara</option>
                                            <option data-link="Narail" value="Kalia">Kalia</option>
                                            <option data-link="Satkhira" value="Satkhira Sadar">Satkhira Sadar
                                            </option>
                                            <option data-link="Satkhira" value="Shyamnagar">Shyamnagar</option>
                                            <option data-link="Satkhira" value="Assasuni">Assasuni</option>
                                            <option data-link="Satkhira" value="Kaliganj">Kaliganj</option>
                                            <option data-link="Satkhira" value="Debhata">Debhata</option>
                                            <option data-link="Satkhira" value="Kalaroa">Kalaroa</option>
                                            <option data-link="Satkhira" value="Tala">Tala</option>
                                            <option data-link="Mymensingh" value="Mymensingh Sadar">Mymensingh Sadar
                                            </option>
                                            <option data-link="Mymensingh" value="Muktagachha">Muktagachha</option>
                                            <option data-link="Mymensingh" value="Bhaluka">Bhaluka</option>
                                            <option data-link="Mymensingh" value="Haluaghat">Haluaghat</option>
                                            <option data-link="Mymensingh" value="Gouripur">Gouripur</option>
                                            <option data-link="Mymensingh" value="Dhobaura">Dhobaura</option>
                                            <option data-link="Mymensingh" value="Phulpur">Phulpur</option>
                                            <option data-link="Mymensingh" value="Gafargaon">Gafargaon</option>
                                            <option data-link="Mymensingh" value="Trishal">Trishal</option>
                                            <option data-link="Mymensingh" value="Fulbaria">Fulbaria</option>
                                            <option data-link="Mymensingh" value="Nandail">Nandail</option>
                                            <option data-link="Mymensingh" value="Ishwarganj">Ishwarganj</option>
                                            <option data-link="Mymensingh" value="Tarakanda">Tarakanda</option>
                                            <option data-link="Jamalpur" value="Jamalpur Sadar">Jamalpur Sadar
                                            </option>
                                            <option data-link="Jamalpur" value="Bokshiganj">Bokshiganj</option>
                                            <option data-link="Jamalpur" value="Dewanganj">Dewanganj</option>
                                            <option data-link="Jamalpur" value="Islampur">Islampur</option>
                                            <option data-link="Jamalpur" value="Madarganj">Madarganj</option>
                                            <option data-link="Jamalpur" value="Melandaha">Melandaha</option>
                                            <option data-link="Jamalpur" value="Sarishabari">Sarishabari</option>
                                            <option data-link="Sherpur" value="Sherpur Sadar">Sherpur Sadar</option>
                                            <option data-link="Sherpur" value="Nokla">Nokla</option>
                                            <option data-link="Sherpur" value="Sreebordi">Sreebordi</option>
                                            <option data-link="Sherpur" value="Nalitabari">Nalitabari</option>
                                            <option data-link="Sherpur" value="Jhenaigati">Jhenaigati</option>
                                            <option data-link="Netrokona" value="Netrokona Sadar">Netrokona Sadar
                                            </option>
                                            <option data-link="Netrokona" value="Kendua">Kendua</option>
                                            <option data-link="Netrokona" value="Mohangonj">Mohangonj</option>
                                            <option data-link="Netrokona" value="Khaliajuri">Khaliajuri</option>
                                            <option data-link="Netrokona" value="Purbodhola">Purbodhola</option>
                                            <option data-link="Netrokona" value="Atpara">Atpara</option>
                                            <option data-link="Netrokona" value="Madan">Madan</option>
                                            <option data-link="Netrokona" value="Kolmkakanda">Kolmkakanda</option>
                                            <option data-link="Netrokona" value="Barhatta">Barhatta</option>
                                            <option data-link="Netrokona" value="Durgapur">Durgapur</option>
                                            <option data-link="Bogura" value="Bogura Sadar">Bogura Sadar</option>
                                            <option data-link="Bogura" value="Gabtali">Gabtali</option>
                                            <option data-link="Bogura" value="Sariakandi">Sariakandi</option>
                                            <option data-link="Bogura" value="Adamdighi">Adamdighi</option>
                                            <option data-link="Bogura" value="Sonatala">Sonatala</option>
                                            <option data-link="Bogura" value="Sherpur">Sherpur</option>
                                            <option data-link="Bogura" value="Kahaloo">Kahaloo</option>
                                            <option data-link="Bogura" value="Shibganj">Shibganj</option>
                                            <option data-link="Bogura" value="Dupchanchia">Dupchanchia</option>
                                            <option data-link="Bogura" value="Nandigram">Nandigram</option>
                                            <option data-link="Bogura" value="Sahajanpur">Sahajanpur</option>
                                            <option data-link="Bogura" value="Dhunot">Dhunot</option>
                                            <option data-link="Joypurhat" value="Joypurhat Sadar">Joypurhat Sadar
                                            </option>
                                            <option data-link="Joypurhat" value="Akkelpur">Akkelpur</option>
                                            <option data-link="Joypurhat" value="Khetlal">Khetlal</option>
                                            <option data-link="Joypurhat" value="Panchbibi">Panchbibi</option>
                                            <option data-link="Joypurhat" value="Kalai">Kalai</option>
                                            <option data-link="Naogaon" value="Naogaon Sadar">Naogaon Sadar</option>
                                            <option data-link="Naogaon" value="Atrai">Atrai</option>
                                            <option data-link="Naogaon" value="Dhamoirhat">Dhamoirhat</option>
                                            <option data-link="Naogaon" value="Badalgachhi">Badalgachhi</option>
                                            <option data-link="Naogaon" value="Niamatpur">Niamatpur</option>
                                            <option data-link="Naogaon" value="Manda">Manda</option>
                                            <option data-link="Naogaon" value="Mohadevpur">Mohadevpur</option>
                                            <option data-link="Naogaon" value="Patnitala">Patnitala</option>
                                            <option data-link="Naogaon" value="Porsha">Porsha</option>
                                            <option data-link="Naogaon" value="Sapahar">Sapahar</option>
                                            <option data-link="Naogaon" value="Raninagar">Raninagar</option>
                                            <option data-link="Natore" value="Natore Sadar">Natore Sadar</option>
                                            <option data-link="Natore" value="Bagatipara">Bagatipara</option>
                                            <option data-link="Natore" value="Singra">Singra</option>
                                            <option data-link="Natore" value="Boraigram">Boraigram</option>
                                            <option data-link="Natore" value="Gurudaspur">Gurudaspur</option>
                                            <option data-link="Natore" value="Lalpur">Lalpur</option>
                                            <option data-link="Chapainawabganj" value="Chapai Nawabganj Sadar">Chapai
                                                Nawabganj Sadar</option>
                                            <option data-link="Chapainawabganj" value="Nachole">Nachole</option>
                                            <option data-link="Chapainawabganj" value="Shibganj">Shibganj</option>
                                            <option data-link="Chapainawabganj" value="Gomastapur">Gomastapur</option>
                                            <option data-link="Chapainawabganj" value="Bholahat">Bholahat</option>
                                            <option data-link="Pabna" value="Pabna Sadar">Pabna Sadar</option>
                                            <option data-link="Pabna" value="Santhia">Santhia</option>
                                            <option data-link="Pabna" value="Bera">Bera</option>
                                            <option data-link="Pabna" value="Sujanagar">Sujanagar</option>
                                            <option data-link="Pabna" value="Atgharia">Atgharia</option>
                                            <option data-link="Pabna" value="Bhangura">Bhangura</option>
                                            <option data-link="Pabna" value="Faridpur">Faridpur</option>
                                            <option data-link="Pabna" value="Chatmohar">Chatmohar</option>
                                            <option data-link="Pabna" value="Ishwardi">Ishwardi</option>
                                            <option data-link="Rajshahi" value="Bagmara">Bagmara</option>
                                            <option data-link="Rajshahi" value="Paba">Paba</option>
                                            <option data-link="Rajshahi" value="Charghat">Charghat</option>
                                            <option data-link="Rajshahi" value="Durgapur">Durgapur</option>
                                            <option data-link="Rajshahi" value="Godagari">Godagari</option>
                                            <option data-link="Rajshahi" value="Mohanpur">Mohanpur</option>
                                            <option data-link="Rajshahi" value="Bagha">Bagha</option>
                                            <option data-link="Rajshahi" value="Puthia">Puthia</option>
                                            <option data-link="Rajshahi" value="Tanore">Tanore</option>
                                            <option data-link="Sirajganj" value="Sirajganj Sadar">Sirajganj Sadar
                                            </option>
                                            <option data-link="Sirajganj" value="Chauhali">Chauhali</option>
                                            <option data-link="Sirajganj" value="Kamarkhanda">Kamarkhanda</option>
                                            <option data-link="Sirajganj" value="Belkuchi">Belkuchi</option>
                                            <option data-link="Sirajganj" value="Kazipur">Kazipur</option>
                                            <option data-link="Sirajganj" value="Raiganj">Raiganj</option>
                                            <option data-link="Sirajganj" value="Ullahpara">Ullahpara</option>
                                            <option data-link="Sirajganj" value="Tarash">Tarash</option>
                                            <option data-link="Sirajganj" value="Shahjadpur">Shahjadpur</option>
                                            <option data-link="Rangpur" value="Rangpur Sadar">Rangpur Sadar</option>
                                            <option data-link="Rangpur" value="Badarganj">Badarganj</option>
                                            <option data-link="Rangpur" value="Kaunia">Kaunia</option>
                                            <option data-link="Rangpur" value="Gangachhara">Gangachhara</option>
                                            <option data-link="Rangpur" value="Mithapukur">Mithapukur</option>
                                            <option data-link="Rangpur" value="Taraganj">Taraganj</option>
                                            <option data-link="Rangpur" value="Pirganj">Pirganj</option>
                                            <option data-link="Rangpur" value="Pirgachha">Pirgachha</option>
                                            <option data-link="Nilphamari" value="Nilphamari Sadar">Nilphamari Sadar
                                            </option>
                                            <option data-link="Nilphamari" value="Jaldhaka">Jaldhaka</option>
                                            <option data-link="Nilphamari" value="Syedpur">Syedpur</option>
                                            <option data-link="Nilphamari" value="Dimla">Dimla</option>
                                            <option data-link="Nilphamari" value="Kishoreganj">Kishoreganj</option>
                                            <option data-link="Nilphamari" value="Domar">Domar</option>
                                            <option data-link="Dinajpur" value="Dinajpur Sadar">Dinajpur Sadar
                                            </option>
                                            <option data-link="Dinajpur" value="Birampur">Birampur</option>
                                            <option data-link="Dinajpur" value="Biral">Biral</option>
                                            <option data-link="Dinajpur" value="Fulbari">Fulbari</option>
                                            <option data-link="Dinajpur" value="Hakimpur">Hakimpur</option>
                                            <option data-link="Dinajpur" value="Khansama">Khansama</option>
                                            <option data-link="Dinajpur" value="Nawabganj">Nawabganj</option>
                                            <option data-link="Dinajpur" value="Parbatipur">Parbatipur</option>
                                            <option data-link="Dinajpur" value="Birganj">Birganj</option>
                                            <option data-link="Dinajpur" value="Kaharole">Kaharole</option>
                                            <option data-link="Dinajpur" value="Chirirbandar">Chirirbandar</option>
                                            <option data-link="Dinajpur" value="Ghoraghat">Ghoraghat</option>
                                            <option data-link="Dinajpur" value="Bochaganj">Bochaganj</option>
                                            <option data-link="Panchagarh" value="Panchagarh Sadar">Panchagarh Sadar
                                            </option>
                                            <option data-link="Panchagarh" value="Atwari">Atwari</option>
                                            <option data-link="Panchagarh" value="Boda">Boda</option>
                                            <option data-link="Panchagarh" value="Debiganj">Debiganj</option>
                                            <option data-link="Panchagarh" value="Tetulia">Tetulia</option>
                                            <option data-link="Gaibandha" value="Gaibandha Sadar">Gaibandha Sadar
                                            </option>
                                            <option data-link="Gaibandha" value="Palashbari">Palashbari</option>
                                            <option data-link="Gaibandha" value="Fulchhari">Fulchhari</option>
                                            <option data-link="Gaibandha" value="Sadullapur">Sadullapur</option>
                                            <option data-link="Gaibandha" value="Sundarganj">Sundarganj</option>
                                            <option data-link="Gaibandha" value="Gobindaganj">Gobindaganj</option>
                                            <option data-link="Gaibandha" value="Saghata">Saghata</option>
                                            <option data-link="Kurigram" value="Kurigram Sadar">Kurigram Sadar
                                            </option>
                                            <option data-link="Kurigram" value="Phulbari">Phulbari</option>
                                            <option data-link="Kurigram" value="Nageshwari">Nageshwari</option>
                                            <option data-link="Kurigram" value="Rajarhat">Rajarhat</option>
                                            <option data-link="Kurigram" value="Bhurungamari">Bhurungamari</option>
                                            <option data-link="Kurigram" value="Ulipur">Ulipur</option>
                                            <option data-link="Kurigram" value="Charrajibpur">Charrajibpur</option>
                                            <option data-link="Kurigram" value="Rowmari">Rowmari</option>
                                            <option data-link="Kurigram" value="Chilmari">Chilmari</option>
                                            <option data-link="Lalmonirhat" value="Lalmonirhat Sadar">Lalmonirhat
                                                Sadar
                                            </option>
                                            <option data-link="Lalmonirhat" value="Patgram">Patgram</option>
                                            <option data-link="Lalmonirhat" value="Aditmari">Aditmari</option>
                                            <option data-link="Lalmonirhat" value="Hatibandha">Hatibandha</option>
                                            <option data-link="Lalmonirhat" value="Kaliganj">Kaliganj</option>
                                            <option data-link="Thakurgaon" value="Thakurgaon Sadar">Thakurgaon Sadar
                                            </option>
                                            <option data-link="Thakurgaon" value="Baliadangi">Baliadangi</option>
                                            <option data-link="Thakurgaon" value="Pirganj">Pirganj</option>
                                            <option data-link="Thakurgaon" value="Ranisankail">Ranisankail</option>
                                            <option data-link="Thakurgaon" value="Haripur">Haripur</option>
                                            <option data-link="Sylhet" value="Sylhet Sadar">Sylhet Sadar</option>
                                            <option data-link="Sylhet" value="Beanibazar">Beanibazar</option>
                                            <option data-link="Sylhet" value="Golapganj">Golapganj</option>
                                            <option data-link="Sylhet" value="Companiganj">Companiganj</option>
                                            <option data-link="Sylhet" value="Fenchuganj">Fenchuganj</option>
                                            <option data-link="Sylhet" value="Bishwanath">Bishwanath</option>
                                            <option data-link="Sylhet" value="Gowainghat">Gowainghat</option>
                                            <option data-link="Sylhet" value="Jaintiapur">Jaintiapur</option>
                                            <option data-link="Sylhet" value="Kanaighat">Kanaighat</option>
                                            <option data-link="Sylhet" value="Balaganj">Balaganj</option>
                                            <option data-link="Sylhet" value="Dakshin Shurma">Dakshin Shurma
                                            </option>
                                            <option data-link="Sylhet" value="Zakiganj">Zakiganj</option>
                                            <option data-link="Sylhet" value="Osmani Nagar">Osmani Nagar</option>
                                            <option data-link="Habiganj" value="Habiganj Sadar">Habiganj Sadar
                                            </option>
                                            <option data-link="Habiganj" value="Lakhai">Lakhai</option>
                                            <option data-link="Habiganj" value="Madhabpur">Madhabpur</option>
                                            <option data-link="Habiganj" value="Nabiganj">Nabiganj</option>
                                            <option data-link="Habiganj" value="Chunarughat">Chunarughat</option>
                                            <option data-link="Habiganj" value="Baniachang">Baniachang</option>
                                            <option data-link="Habiganj" value="Bahubal">Bahubal</option>
                                            <option data-link="Habiganj" value="Ajmiriganj">Ajmiriganj</option>
                                            <option data-link="Habiganj" value="Shayestaganj">Shayestaganj</option>
                                            <option data-link="Moulvibazar" value="Moulvibazar Sadar">Moulvibazar
                                                Sadar
                                            </option>
                                            <option data-link="Moulvibazar" value="SreeMangal">SreeMangal</option>
                                            <option data-link="Moulvibazar" value="Kulaura">Kulaura</option>
                                            <option data-link="Moulvibazar" value="Kamalganj">Kamalganj</option>
                                            <option data-link="Moulvibazar" value="Juri">Juri</option>
                                            <option data-link="Moulvibazar" value="Barlekha">Barlekha</option>
                                            <option data-link="Moulvibazar" value="Rajnagar">Rajnagar</option>
                                            <option data-link="Sunamganj" value="Sunamganj Sadar">Sunamganj Sadar
                                            </option>
                                            <option data-link="Sunamganj" value="Sunamganj South">Sunamganj South
                                            </option>
                                            <option data-link="Sunamganj" value="Chhatak">Chhatak</option>
                                            <option data-link="Sunamganj" value="Jagannathpur">Jagannathpur</option>
                                            <option data-link="Sunamganj" value="Bishwamvarpur">Bishwamvarpur
                                            </option>
                                            <option data-link="Sunamganj" value="Tahirpur">Tahirpur</option>
                                            <option data-link="Sunamganj" value="Derai">Derai</option>
                                            <option data-link="Sunamganj" value="Dharampasha">Dharampasha</option>
                                            <option data-link="Sunamganj" value="Shalla">Shalla</option>
                                            <option data-link="Sunamganj" value="Dowarabazar">Dowarabazar</option>
                                            <option data-link="Sunamganj" value="Jamalganj">Jamalganj</option>
                                        </select>
                                        <select name="search_area" class="form-select" id="search_area">
                                            <option value="">select area</option>
                                            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($val->id); ?>" <?php echo e(request()->get('search_area') == $val->id ? 'selected' : ''); ?>><?php echo e($val->value); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                    </div>
                                    <div class="input-group">
                                        <select name="search_market" class="form-select" id="search_market">
                                            <option value="">select market</option>
                                            <?php $__currentLoopData = $markets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($val->id); ?>" <?php echo e(request()->get('search_market') == $val->id ? 'selected' : ''); ?>><?php echo e($val->value); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <select name="search_respodent" class="form-select" id="search_respodent">
                                            <option value="">Select respondent type</option>
                                            <option value="Customer"
                                                <?php echo e(request()->get('search_respodent') == 'Customer' ? 'selected' : ''); ?>>
                                                Customer</option>
                                            <option value="Seller"
                                                <?php echo e(request()->get('search_respodent') == 'Seller' ? 'selected' : ''); ?>>
                                                Seller</option>
                                            <option value="LBW Worker"
                                                <?php echo e(request()->get('search_respodent') == 'LBW Worker' ? 'selected' : ''); ?>>
                                                LBW Worker</option>
                                            
                                        </select>
                                        <select name="search_status" class="form-select" id="search_status">
                                            <option value="">Select Status</option>
                                            <option value="2"
                                                <?php echo e(request()->get('search_status') == '2' ? 'selected' : ''); ?>>Verified
                                            </option>
                                            <option value="0"
                                                <?php echo e(request()->get('search_status') == '0' ? 'selected' : ''); ?>>Pending
                                            </option>
                                        </select>



                                        <div class="input-group input-daterange my-1">
                                            <input type="text" name="search_text"
                                                value="<?php echo e(request()->get('search_text')); ?>" class="form-control"
                                                placeholder="Search by name/mobile/email/gender">

                                            <input type="text" class="form-control datepicker" name="date_from"
                                                placeholder="Date From" value="<?php echo e(request()->get('date_from')); ?>" aria-label="DateFrom">
                                            <span class="input-group-text">to</span>
                                            <input type="text" class="form-control datepicker" name="date_to"
                                                placeholder="Date To" value="<?php echo e(request()->get('date_to')); ?>" aria-label="DateTo">

                                            

                                            <div class="input-group-append">
                                                <button class="btn btn-secondary mx-1 filter_btn" name="submit_btn"
                                                    type="submit" value="search">
                                                    <i class="fa fa-search"></i> Filter Data
                                                </button>
                                                <a href='<?php echo e(request()->get('status') == 'archived' ? url('/user_responses?status=archived') : url('/user_responses')); ?>'
                                                    class="btn btn-xs btn-primary me-1 refresh_btn"><i
                                                        class="fa fa-refresh"></i> Refresh</a>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.export')): ?>
                                                    
                                                    

                                                    <button class="btn btn-xs btn-success float-end me-1 export_btn"
                                                        name="submit_btn" value="export" type="submit">
                                                        <i class="fa-solid fa-download"></i> Export
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                            </div>
                        </form>
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Response Date</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Gender</th>
                                    <th>Respondent</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $user_responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($index + $user_responses->firstItem()); ?></td>
                                        <td><?php echo e($val->response_date); ?></td>
                                        <td><?php echo e(isset($val->registered_user) ? $val->registered_user->full_name : ''); ?>

                                        </td>
                                        <td><?php echo e(isset($val->registered_user) ? $val->registered_user->email : ''); ?></td>
                                        <td><?php echo e(isset($val->registered_user) ? $val->registered_user->mobile_no : ''); ?>

                                        </td>
                                        <td><?php echo e(isset($val->registered_user) ? $val->registered_user->gender : ''); ?>

                                        </td>
                                        
                                        <td><?php echo e(isset($val->registered_user) ? $val->registered_user->respondent_type : ''); ?>

                                        </td>
                                        <td><?php echo App\Lib\Webspice::status($val->status); ?></td>


                                        <td class="text-nowrap">
                                            <?php if(request()->get('status') == 'archived'): ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.restore')): ?>
                                                    <a href=""
                                                        class="btn btn-primary btn-sm btn-restore-<?php echo e($val->id); ?>"
                                                        onclick="event.preventDefault(); restoreConfirmation(<?php echo e($val->id); ?>)"><i
                                                            class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                                    <form id="restore-form-<?php echo e($val->id); ?>"
                                                        action="<?php echo e(route('user_responses.restore', Crypt::encryptString($val->id))); ?>"
                                                        method="POST" style="display: none">
                                                        <?php echo method_field('POST'); ?>
                                                        <?php echo csrf_field(); ?>
                                                    </form>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.force_delete')): ?>
                                                    <a href=""
                                                        class="btn btn-danger btn-sm btn-force-delete-<?php echo e($val->id); ?>"
                                                        onclick="event.preventDefault(); forceDelete(<?php echo e($val->id); ?>)"><i
                                                            class="fa-solid fa-remove"></i> Force Delete</a>
                                                    <form id="force-delete-form-<?php echo e($val->id); ?>"
                                                        style="display: none"
                                                        action="<?php echo e(route('user_responses.force-delete', Crypt::encryptString($val->id))); ?>"
                                                        method="POST">
                                                        <?php echo method_field('DELETE'); ?>
                                                        <?php echo csrf_field(); ?>
                                                    </form>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.edit')): ?>
                                                    <?php if($val->status == 1): ?>
                                                        
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.verify')): ?>
                                                    <?php if($val->status == 0): ?>
                                                        <a href=""
                                                            class="btn btn-outline-success btn-sm btn-verify-<?php echo e($val->id); ?>"
                                                            onclick="event.preventDefault(); confirmVerify(<?php echo e($val->id); ?>)"><i
                                                                class="fas fa-check"></i> Verify</a>
                                                        <form id="verify-form-<?php echo e($val->id); ?>"
                                                            style="display: none"
                                                            action="<?php echo e(route('user_responses.verify', Crypt::encryptString($val->id))); ?>"
                                                            method="POST">
                                                            <?php echo method_field('PUT'); ?>
                                                            <?php echo csrf_field(); ?>
                                                        </form>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <button class="btn btn-sm btn-secondary me-1 mt-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#details-modal-<?php echo e($val->id); ?>">
                                                    <i class="fa-solid fa-magnifying-glass-plus"></i></button>

                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.delete')): ?>
                                                    <?php if($val->status == 0): ?>
                                                        <a href=""
                                                            class="btn btn-outline-danger btn-sm btn-delete-<?php echo e($val->id); ?>"
                                                            onclick="event.preventDefault(); confirmDelete(<?php echo e($val->id); ?>)"><i
                                                                class="fa-solid fa-trash"></i> Delete</a>
                                                        <form id="delete-form-<?php echo e($val->id); ?>"
                                                            style="display: none"
                                                            action="<?php echo e(route('user_responses.destroy', Crypt::encryptString($val->id))); ?>"
                                                            method="POST">
                                                            <?php echo method_field('DELETE'); ?>
                                                            <?php echo csrf_field(); ?>
                                                        </form>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($user_responses->withQueryString()->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('user_response.detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->startPush('scripts'); ?>
        <script>
            let confirmVerify = (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to cancel this again!'",
                    icon: 'warning',
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, verify it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.btn-verify-' + id).addClass('disabledAnchor');
                        $('.btn-verify-' + id).html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...'
                        );
                        document.getElementById('verify-form-' + id).submit();
                        processing('Verifying...');
                    }
                })
            }

            $(document).ready(function() {




                // if (!searchDistrict && !searchThana) {
                $("#drpDistrict, #drpUpazilla").children('option').hide();
                $("#drpDistrict, #drpUpazilla").val("");
                // }

                var searchDivision = "<?php echo e(request()->get('search_division')); ?>";
                if (searchDivision) {
                    $("#drpDivision option[value=" + searchDivision + "]").attr('selected', 'selected');
                }
                var searchDistrict = "<?php echo e(request()->get('search_district')); ?>";
                if (searchDistrict) {
                    $("#drpDistrict").children('option[data-link="' + searchDivision + '"]').show();
                    $("#drpDistrict option[value=" + searchDistrict + "]").attr('selected', 'selected');

                }
                var searchThana = "<?php echo e(request()->get('search_thana')); ?>";
                if (searchThana) {
                    $("#drpUpazilla").children('option[data-link="' + searchDistrict + '"]').show();
                    $("#drpUpazilla option[value=" + searchThana + "]").attr('selected', 'selected');
                }

                $("#drpDivision").change(function() {
                    $("#drpDistrict, #drpUpazilla").children('option').hide();
                    $("#drpDistrict, #drpUpazilla").val("");
                    if ($(this).val() && $(this).val() != "" && $(this).val() != NaN) {
                        var myValue = $(this).val();
                        $("#drpDistrict").children('option[data-link="' + myValue + '"]').show();
                    }
                });
                $("#drpDistrict").change(function() {
                    $("#drpUpazilla").children('option').hide();
                    $("#drpUpazilla").val("");
                    if ($(this).val() && $(this).val() != "" && $(this).val() != NaN) {
                        var myValue = $(this).val();
                        $("#drpUpazilla").children('option[data-link="' + myValue + '"]').show();
                    }
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/user_response/index.blade.php ENDPATH**/ ?>