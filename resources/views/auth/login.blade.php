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
                            <h2 class="mb-2 ">Login</h2>
                            <p>Login to stay connected.</p>
                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            <form method="POST" action="{{ route('login') }}" data-toggle="validator">
                            {{csrf_field()}}
                               <div class="row">
                                  <div class="col-lg-12">
                                     <div class="floating-label form-group">
                                        <input id="email" type="email" name="email"  value="{{old('email')}}" class="floating-input form-control"  placeholder=" " required >
                                        <label>Email <span class="text-danger">*</span></label>
                                     </div>
                                  </div>
                                  <div class="col-lg-12">
                                     <div class="floating-label form-group">
                                        <input class="floating-input form-control" type="password" name="password"  required autocomplete="current-password" placeholder=" ">
                                        <label>Password <span class="text-danger">*</span></label>
                                     </div>
                                  </div>
                                  <div class="col-lg-6">
                                     <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label control-label-1 " for="customCheck1">Remember Me</label>
                                     </div>
                                  </div>
                                  <div class="col-lg-6">
                                     <a href="{{route('auth.recover-password')}}" class=" float-right">Forgot Password?</a>
                                  </div>
                               </div>
                               <button type="submit" class="btn btn-primary">Login</button>
                               <p class="mt-3">
                                  Create an Account <a href="{{route('auth.register')}}" class=" text-underline">Register</a>
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
