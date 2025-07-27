<x-guest-layout>
<section class="login-content">
    <div class="container">
       <div class="row align-items-center justify-content-center height-self-center">
          <div class="col-lg-8">
             <div class="card auth-card">
                <div class="card-body p-0">
                   <div class="d-flex align-items-center auth-content">
                      <div class="col-lg-6  content-left">
                         <div class="p-3">
                            <h2 class="mb-2 ">Register</h2>
                            <p>Create your account.</p>
                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            <form method="POST" action="{{ route('register') }}" data-toggle="validator">
                                {{csrf_field()}}
                                <div class="row">
                                  <div class="col-lg-6">
                                     <div class="floating-label form-group">
                                        <input id="name"  name="first_name" value="{{old('first_name')}}"  class="floating-input form-control" type="text" placeholder=" " required >
                                        <label>Full Name <span class="text-danger">*</span></label>
                                     </div>
                                  </div>
                                  <div class="col-lg-6">
                                     <div class="floating-label form-group">
                                        <input class="floating-input form-control" type="text" name="last_name" placeholder=" " value="{{old('last_name')}}" required>
                                        <label>Last Name <span class="text-danger">*</span></label>
                                     </div>
                                  </div>
                                  <div class="col-lg-6">
                                     <div class="floating-label form-group">
                                        <input class="floating-input form-control" type="email" id="email"  name="email" value="{{old('email')}}" required placeholder=" ">
                                        <label>Email <span class="text-danger">*</span></label>
                                     </div>
                                  </div>
                                  <div class="col-lg-6">
                                     <div class="floating-label form-group">
                                        <input class="floating-input form-control" name="phone_number" type="text" placeholder=" ">
                                        <label>Phone No. <span class="text-danger">*</span></label>
                                     </div>
                                  </div>

                                  <div class="col-lg-12">
                                     <div class="floating-label form-group">
                                        <input class="floating-input form-control" name="company_name" type="text" placeholder=" ">
                                        <label>Company Name. <span class="text-danger">*</span></label>
                                     </div>
                                  </div>

                                  <div class="col-lg-12">
                                     <div class="floating-label form-group">
                                        <textarea class="floating-input form-control" name="company_address" placeholder=" "></textarea>
                                        <label>Company Address. <span class="text-danger">*</span></label>
                                     </div>
                                  </div>

                                  <div class="col-lg-12">
                                       <div class="form-group">
                                        <select class="floating-input form-control" name="company_type" placeholder=" ">
                                          <option value="">Select company type</option>
                                          <option value="perusahaan-perorangan">Perusahaan Perorangan</option>
                                          <option value="fa">Firma (FA)</option>
                                          <option value="cv">Persekutuan Komanditer (CV)</option>
                                          <option value="pt">Perseroan Terbatas (PT)</option>
                                          <option value="koperasi">Koperasi</option>
                                          <option value="yayasan">Yayasan</option>
                                          <option value="bumn">Badan Usaha Milik Negara (BUMN)</option>
                                          <option value="lainnya">Lainnya</option>
                                        </select>
                                        
                                       </div>
                                  </div>
                                  
                                  <div class="col-lg-6">
                                     <div class="floating-label form-group">
                                        <input class="floating-input form-control" type="password" id="password" name="password" required autocomplete="new-password" placeholder=" ">
                                        <label>Password <span class="text-danger">*</span></label>
                                     </div>
                                  </div>
                                  <div class="col-lg-6">
                                     <div class="floating-label form-group">
                                        <input class="floating-input form-control" type="password" name="password_confirmation" required placeholder=" ">
                                        <label>Confirm Password <span class="text-danger">*</span></label>
                                     </div>
                                  </div>
                                  <div class="col-lg-12">
                                     <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" required>
                                        <label class="custom-control-label " for="customCheck1">I agree with the terms of use</label>
                                     </div>
                                  </div>
                               </div>
                               <button type="submit" class="btn btn-primary">Register</button>
                               <p class="mt-3">
                                  Already have an Account <a href="{{route('auth.login')}}" class=" text-underline">Login</a>
                               </p>
                            </form>
                         </div>
                      </div>
                      <div class="col-lg-6 content-right">
                         <img src="{{ asset('images/login/01.png') }}" class="img-fluid image-right" alt="">
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
</x-guest-layout>
