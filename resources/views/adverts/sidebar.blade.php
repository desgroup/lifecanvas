@php
    $ad = rand (1 , 3 );
@endphp

@switch($ad)
    @case(1)
    <div class="card">
        <div class="image-container" style="display: flex; align-items: center; justify-content: center; background-color: #F2F2F2">
            <img src="/ads/img/Rome_Pantheon.jpg" height= "100px" alt="" class="img-fluid">
        </div>
        <div class="card-body text-center">
            <h4 class="color-primary">Travel to Rome in 2018</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
            <a href="javascript:void(0)" class="btn btn-primary btn-raised">
                <i class="zmdi zmdi-flower"></i> Find out More</a>
        </div>
    </div>
    @break

    @case(2)
    <div class="card">
        <div class="image-container" style="display: flex; align-items: center; justify-content: center; background-color: #F2F2F2">
            <img src="/ads/img/Angkor_Wat.jpg" height= "100px" alt="" class="img-fluid">
        </div>
        <div class="card-body text-center">
            <h4 class="color-primary">Visit Angkor Wat</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
            <a href="javascript:void(0)" class="btn btn-primary btn-raised">
                <i class="zmdi zmdi-flower"></i> Find out More</a>
        </div>
    </div>
    @break

    @default
    <div class="card">
        <div class="image-container" style="display: flex; align-items: center; justify-content: center; background-color: #F2F2F2">
            <img src="/ads/img/Brasilia.jpg" height= "100px" alt="" class="img-fluid">
        </div>
        <div class="card-body text-center">
            <h4 class="color-primary">Travel to Basiília</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
            <a href="javascript:void(0)" class="btn btn-primary btn-raised">
                <i class="zmdi zmdi-flower"></i> Find out More</a>
        </div>
    </div>
@endswitch