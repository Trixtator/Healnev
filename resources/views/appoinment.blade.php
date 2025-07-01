@extends('layouts.shared')

@section('content')




<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block text-center">
            <span class="text-white">Book your Seat</span>
            <h1 class="text-capitalize mb-5 text-lg">Appoinment</h1>
          </div>
        </div>
      </div>
    </div>
  </section>
  
<section id="pendaftaran-mcu" class="section cta-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="cta-content">
                    <h2 class="title-color">Daftar untuk <br>Medical Check-Up</h2>
                    <p class="lead">Jaga kesehatan Anda dengan melakukan medical check-up secara rutin. Isi formulir berikut untuk mendaftar.</p>
                </div>
            </div>
            <div class="col-lg-5">
                <form id="form-pendaftaran-mcu" class="appoinment-form" method="post" action="#">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input name="name" id="name" type="text" class="form-control" placeholder="Nama Lengkap" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input name="phone" id="phone" type="tel" class="form-control" placeholder="Nomor Telepon" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input name="email" id="email" type="email" class="form-control" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input name="birthdate" id="birthdate" type="date" class="form-control" placeholder="Tanggal Lahir" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input name="address" id="address" type="text" class="form-control" placeholder="Alamat" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="form-control" name="package" id="package" required>
                                    <option value="">Pilih Paket MCU</option>
                                    <option value="basic">Basic</option>
                                    <option value="standard">Standard</option>
                                    <option value="premium">Premium</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-2 mb-4">
                        <textarea name="notes" id="notes" class="form-control" rows="6" placeholder="Catatan Tambahan (opsional)"></textarea>
                    </div>
                    <button type="submit" class="btn btn-main btn-round-full">Daftar <i class="icofont-simple-right ml-2"></i></button>
                </form>
            </div>
        </div>
    </div>
</section>
  
  
  
  


@endsection