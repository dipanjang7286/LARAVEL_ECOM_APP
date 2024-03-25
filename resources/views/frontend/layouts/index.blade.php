@include('frontend.layouts.header')

<section id="billboard" class="position-relative overflow-hidden bg-light-blue">
  @include('frontend.parts.billboard')
</section>
<section id="company-services" class="padding-large">
  @include('frontend.parts.company-services')
</section>
<section id="mobile-products" class="product-store position-relative padding-large no-padding-top">
  @include('frontend.parts.mobile-products')
</section>
<section id="smart-watches" class="product-store padding-large position-relative">
  @include('frontend.parts.smart-watches')
</section>
<section id="yearly-sale" class="bg-light-blue overflow-hidden mt-5 padding-xlarge"
  style="background-image: url('{{asset("frontend_assets/images/single-image1.png")}}');background-position: right; background-repeat: no-repeat;">
  @include('frontend.parts.yearly-sale')
</section>
<section id="latest-blog" class="padding-large">
  @include('frontend.parts.latest-blog')
</section>

@include('frontend.layouts.footer')