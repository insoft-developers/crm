<x-app-layout>
<div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="card card-block card-stretch card-height">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Avatar Sizing</h4>
                     </div>
                     <div class="header-action">
                           <i  type="button" data-toggle="collapse" data-target="#avatar-1" aria-expanded="false" aria-controls="alert-1">
                              <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                              </svg>
                           </i>
                        </div>
                  </div>
                  <div class="card-body">
                     <div class="collapse" id="avatar-1">
                           <div class="card"><kbd class="bg-dark"><pre id="avatar-sizing" class="text-white"><code>
&#x3C;div class=&#x22;iq-avatars d-flex flex-wrap align-items-center&#x22;&#x3E;   
   &#x3C;div class=&#x22;iq-avatar&#x22;&#x3E;
      &#x3C;img class=&#x22;avatar-100 rounded&#x22; src=&#x22;{{ asset("/images/user/1.jpg")}}&#x22; alt=&#x22;#&#x22; data-original-title=&#x22;&#x22; title=&#x22;&#x22;&#x3E;
   &#x3C;/div&#x3E;
&#x3C;/div&#x3E;
</code></pre></kbd></div>
                        </div>
                     <div class="iq-avatars d-flex flex-wrap align-items-center">
                        <div class="iq-avatar">
                           <img class="avatar-100 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-90 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-80 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-70 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-60 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-50 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-40 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-30 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="card card-block card-stretch card-height">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Shape Rounded</h4>
                     </div>
                  <div class="header-action">
                           <i  type="button" data-toggle="collapse" data-target="#avatar-2" aria-expanded="false" aria-controls="alert-1">
                              <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                              </svg>
                           </i>
                        </div>
                  </div>
                  <div class="card-body">
                     <div class="collapse" id="avatar-2">
                           <div class="card"><kbd class="bg-dark"><pre id="shape-rounded" class="text-white"><code>
&#x3C;div class=&#x22;iq-avatars d-flex flex-wrap align-items-center&#x22;&#x3E;
   &#x3C;div class=&#x22;iq-avatar&#x22;&#x3E;
      &#x3C;img class=&#x22;avatar-80 rounded&#x22; src=&#x22;{{ asset("/images/user/1.jpg")}}&#x22; alt=&#x22;#&#x22; data-original-title=&#x22;&#x22; title=&#x22;&#x22;&#x3E;
   &#x3C;/div&#x3E;
&#x3C;/div&#x3E;
</code></pre></kbd></div>
                        </div>
                     <div class="iq-avatars d-flex flex-wrap align-items-center">
                        <div class="iq-avatar">
                           <img class="avatar-80 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-70 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-60 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-50 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-40 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-30 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="card card-block card-stretch card-height">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Shape Rounded Circle</h4>
                     </div>
                  <div class="header-action">
                           <i  type="button" data-toggle="collapse" data-target="#avatar-3" aria-expanded="false" aria-controls="alert-1">
                              <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                              </svg>
                           </i>
                        </div>
                  </div>
                  <div class="card-body">
                     <div class="collapse" id="avatar-3">
                           <div class="card"><kbd class="bg-dark"><pre id="shape-rounded-circle" class="text-white"><code>
&#x3C;div class=&#x22;iq-avatars d-flex flex-wrap align-items-center&#x22;&#x3E;
   &#x3C;div class=&#x22;iq-avatar&#x22;&#x3E;
      &#x3C;img class=&#x22;avatar-80 rounded-small&#x22; src=&#x22;{{ asset("/images/user/1.jpg")}}&#x22; alt=&#x22;#&#x22; data-original-title=&#x22;&#x22; title=&#x22;&#x22;&#x3E;
   &#x3C;/div&#x3E;
&#x3C;/div&#x3E;
</code></pre></kbd></div>
                        </div>
                     <div class="iq-avatars d-flex flex-wrap align-items-center">
                        <div class="iq-avatar">
                           <img class="avatar-80 rounded-small" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-70 rounded-small" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-60 rounded-small" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-50 rounded-small" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-40 rounded-small" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-30 rounded-small" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="card card-block card-stretch card-height">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Image Initials</h4>
                     </div>
                  <div class="header-action">
                           <i  type="button" data-toggle="collapse" data-target="#avatar-4" aria-expanded="false" aria-controls="alert-1">
                              <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                              </svg>
                           </i>
                        </div>
                  </div>
                  <div class="card-body">
                     <div class="collapse" id="avatar-4">
                           <div class="card"><kbd class="bg-dark"><pre id="image-initials" class="text-white"><code>
&#x3C;div class=&#x22;iq-avatars d-flex flex-wrap align-items-center&#x22;&#x3E;
   &#x3C;div class=&#x22;iq-avatar&#x22;&#x3E;
      &#x3C;img class=&#x22;avatar-100 rounded&#x22; src=&#x22;{{ asset("/images/user/1.jpg")}}&#x22; alt=&#x22;#&#x22; data-original-title=&#x22;&#x22; title=&#x22;&#x22;&#x3E;
   &#x3C;/div&#x3E;
&#x3C;/div&#x3E;
</code></pre></kbd></div>
                        </div>
                     <div class="iq-avatars d-flex flex-wrap align-items-center">
                        <div class="iq-avatar">
                           <img class="avatar-100 rounded" src={{ asset("/images/user/i1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-90 rounded" src={{ asset("/images/user/i1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-80 rounded" src={{ asset("/images/user/i1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-70 rounded" src={{ asset("/images/user/i1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-60 rounded" src={{ asset("/images/user/i1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-50 rounded" src={{ asset("/images/user/i1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-40 rounded" src={{ asset("/images/user/i1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-30 rounded" src={{ asset("/images/user/i1.jpg")}} alt="#" data-original-title="" title="">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="card card-block card-stretch card-height">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Status Indicator</h4>
                     </div>
                  <div class="header-action">
                           <i  type="button" data-toggle="collapse" data-target="#avatar-5" aria-expanded="false" aria-controls="alert-1">
                              <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                              </svg>
                           </i>
                        </div>
                  </div>
                  <div class="card-body">
                     <div class="collapse" id="avatar-5">
                           <div class="card"><kbd class="bg-dark"><pre id="status-indicator" class="text-white"><code>
&#x3C;div class=&#x22;iq-avatars d-flex flex-wrap align-items-center&#x22;&#x3E;
   &#x3C;div class=&#x22;iq-avatar&#x22;&#x3E;
      &#x3C;img class=&#x22;avatar-80 rounded&#x22; src=&#x22;{{ asset("/images/user/1.jpg")}}&#x22; alt=&#x22;#&#x22; data-original-title=&#x22;&#x22; title=&#x22;&#x22;&#x3E; &#x3C;span class=&#x22;bg-success iq-dots dots-100&#x22;&#x3E;&#x3C;/span&#x3E;
   &#x3C;/div&#x3E;
&#x3C;/div&#x3E;
</code></pre></kbd></div>
                        </div>
                     <div class="iq-avatars d-flex flex-wrap align-items-center">
                        <div class="iq-avatar">
                           <img class="avatar-80 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title=""> <span class="bg-success iq-dots dots-100"></span>
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-70 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title=""> <span class="iq-dots dots-90"></span>
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-60 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title=""> <span class="bg-success iq-dots dots-80"></span>
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-50 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title=""> <span class="iq-dots dots-80"></span>
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-40 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title=""> <span class="bg-success iq-dots dots-80"></span>
                        </div>
                        <div class="iq-avatar">
                           <img class="avatar-30 rounded" src={{ asset("/images/user/1.jpg")}} alt="#" data-original-title="" title=""> <span class="iq-dots dots-80"></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="card card-block card-stretch card-height">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Image Groups</h4>
                     </div>
                  <div class="header-action">
                           <i  type="button" data-toggle="collapse" data-target="#avatar-6" aria-expanded="false" aria-controls="alert-1">
                              <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                              </svg>
                           </i>
                        </div>
                  </div>
                  <div class="card-body">
                     <div class="collapse" id="avatar-6">
                           <div class="card"><kbd class="bg-dark"><pre id="image-groups" class="text-white"><code>
&#x3C;div class=&#x22;iq-avatars d-flex flex-wrap align-items-center&#x22;&#x3E;
   &#x3C;div class=&#x22;iq-avatar&#x22;&#x3E;
      &#x3C;div class=&#x22;iq-media-group&#x22;&#x3E;
         &#x3C;a href=&#x22;#&#x22; class=&#x22;iq-media&#x22;&#x3E;
            &#x3C;img class=&#x22;img-fluid avatar-60 rounded&#x22; src=&#x22;{{ asset("/images/user/05.jpg")}}&#x22; alt=&#x22;&#x22;&#x3E;
         &#x3C;/a&#x3E;
         &#x3C;a href=&#x22;#&#x22; class=&#x22;iq-media&#x22;&#x3E;
            &#x3C;img class=&#x22;img-fluid avatar-60 rounded&#x22; src=&#x22;{{ asset("/images/user/06.jpg")}}&#x22; alt=&#x22;&#x22;&#x3E;
         &#x3C;/a&#x3E;
         &#x3C;a href=&#x22;#&#x22; class=&#x22;iq-media&#x22;&#x3E;
            &#x3C;img class=&#x22;img-fluid avatar-60 rounded&#x22; src=&#x22;{{ asset("/images/user/07.jpg")}}&#x22; alt=&#x22;&#x22;&#x3E;
         &#x3C;/a&#x3E;
      &#x3C;/div&#x3E;
   &#x3C;/div&#x3E;
&#x3C;/div&#x3E;
</code></pre></kbd></div>
                        </div>
                     <div class="iq-avatars d-flex flex-wrap align-items-center">
                        <div class="iq-avatar">
                           <div class="iq-media-group">
                              <a href="#" class="iq-media">
                                 <img class="img-fluid avatar-60 rounded" src={{ asset("images/user/5.png")}} alt="">
                              </a>
                              <a href="#" class="iq-media">
                                 <img class="img-fluid avatar-60 rounded" src={{ asset("images/user/6.png")}} alt="">
                              </a>
                              <a href="#" class="iq-media">
                                 <img class="img-fluid avatar-60 rounded" src={{ asset("images/user/7.png")}} alt="">
                              </a>
                           </div>
                        </div>
                        <div class="iq-avatar">
                           <div class="iq-media-group">
                              <a href="#" class="iq-media">
                                 <img class="img-fluid avatar-50 rounded" src={{ asset("images/user/5.png")}} alt="">
                              </a>
                              <a href="#" class="iq-media">
                                 <img class="img-fluid avatar-50 rounded" src={{ asset("images/user/6.png")}} alt="">
                              </a>
                              <a href="#" class="iq-media">
                                 <img class="img-fluid avatar-50 rounded" src={{ asset("images/user/7.png")}} alt="">
                              </a>
                           </div>
                        </div>
                        <div class="iq-avatar">
                           <div class="iq-media-group">
                              <a href="#" class="iq-media">
                                 <img class="img-fluid avatar-40 rounded" src={{ asset("images/user/5.png")}} alt="">
                              </a>
                              <a href="#" class="iq-media">
                                 <img class="img-fluid avatar-40 rounded" src={{ asset("images/user/6.png")}} alt="">
                              </a>
                              <a href="#" class="iq-media">
                                 <img class="img-fluid avatar-40 rounded" src={{ asset("images/user/7.png")}} alt="">
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
</x-app-layout>
