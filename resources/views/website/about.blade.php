@extends('layout.siteLayout')
@section('title')
    @lang('website.favorite')
@endsection

@section('content')

    <div class="page_container">


    <div class="cards_container">

        <div class="about-us-card">
            <div class="about-us-content">
                <h2 class="title">محمد العاجز</h2>
                <p class="copy">أنا مبرمج ويب محترف و مستعد للعمل في اي مشروع. إذا كنت تريد موقع أو تطبيق ويب تواصل معي!
                    :)</p>
            </div>
        </div>

        <div class="about-us-card doctor-card">
            <div class="about-us-content">
                <h2 class="title">د.سالم اليازجي</h2>
                <p class="copy">أنا مبرمج ويب محترف و مشرف هذا المشروع. إذا كنت تريد موقع أو تطبيق ويب تواصل معي! :)</p>
            </div>
        </div>

        <div class="about-us-card">
            <div class="about-us-content">
                <h2 class="title">محمود طبازة</h2>
                <p class="copy">أنا مبرمج ويب محترف و مستعد للعمل في اي مشروع. إذا كنت تريد موقع أو تطبيق ويب تواصل معي!
                    :)</p>
            </div>
        </div>

    </div>

    <div class="cards_container">

        <div class="about-us-card2">
            <div class="about-us-content">
                <h2 class="title">عبد الرحمن العطل</h2>
                <p class="copy">أنا مبرمج ويب محترف و مستعد للعمل في اي مشروع. إذا كنت تريد موقع أو تطبيق ويب تواصل معي!
                    :)</p>
            </div>
        </div>

        <div class="about-us-card2">
            <div class="about-us-content">
                <h2 class="title">عمر أبو شملة</h2>
                <p class="copy">أنا مبرمج ويب محترف و مستعد للعمل في اي مشروع. إذا كنت تريد موقع أو تطبيق ويب تواصل معي!
                    :)</p>
            </div>
        </div>

    </div>

    <div class="sm:flex items-center max-w-screen-xl">

        <div class="sm:w-1/2 p-5">
            <div class="text" style="text-align: right">
                <h2 class="my-4 font-bold text-3xl  sm:text-4xl ">عن <span class="text-indigo-600">محاضرات الطالب الجامعي</span>
                </h2>
                <p class="text-gray-700">فريق تقني متخصص في تقديم خدمات البرمجة من تطوير مواقع الويب وتطبيقات الهواتف
                    الذكية والمنظومات والنظم السحابية, كذلك نقدم مجموعة من الحلول الجاهزة من منظومات مثل منظومة مبيعات
                    ومنظومة ادارة مراكز التدريب وإدارة المدارس. </p>
            </div>
        </div>

        <div class="sm:w-1/2 p-10">
            <div class="image object-center text-center">
                <img src="https://www.pentame.ae/images/about-us.svg">
            </div>
        </div>

    </div>

    <div class="sm:flex items-center max-w-screen-xl">
        <div class="sm:w-1/2 p-10">
            <div class="image object-center text-center">
                <img src="https://seersco.com/images/design-new/about-us-banner.svg">
            </div>
        </div>

        <div class="sm:w-1/2 p-5">
            <div class="text" style="text-align: right">
                <h2 class="my-4 font-bold text-3xl  sm:text-4xl ">من <span class="text-indigo-600">هنا البداية</span>
                </h2>
                <p class="text-gray-700">شغفنا بالتكنولوجيا وإيماننا بأنها المستقبل أسس لدينا الكثير من الطموحات
                    للإستثمار في هذا المجال, من هنا إنطلقت فكرة غيمة البرمجيات, حيث إزداد الطلب على البرمجيات بشكل كبير
                    مما تقدمه من مساعدة كبيرة للمؤسسات والشركات , أتت تسمية غيمة البرمجيات نظرا للتطور لأحد أهم التقنيات
                    الحديثة وهي الحوسبة السحابية وهي تتمثل في بناء الأنظمة ووضعها في ما يسمى cloud وهذا اصبحا شائعا بعد
                    توسع شبكة الإنترنت وإزدياد سرعة الإنترنت , مما جعلنا نؤمن بهذه الفكرة وهي بناء الأنظمة السحابية أو
                    الأنظمة التي تعتمد على الكلاود في تخزين بيناتها.</p>
            </div>
        </div>

    </div>

    <div class="sm:flex items-center max-w-screen-xl">
        <div class="sm:w-1/2 p-5">
            <div class="text" style="text-align: right">
                <h2 class="my-4 font-bold text-3xl  sm:text-4xl ">ما <span class="text-indigo-600"> يميزنا </span>
                </h2>
                <p class="text-gray-700" style="font-size: 25px;">الخبرة في سوق العمل <i class="fas fa-caret-left" style="color: #5a67d8;font-size: 25px;"></i></p>
                <p class="text-gray-700" > تم جمع فريقنا بعناية, حيث كل فريق العمل سبق له العمل في العديد من الشركات </p>

                <p class="text-gray-700" style="font-size: 25px;">لكل منا تخصصه <i class="fas fa-caret-left" style="color: #5a67d8;font-size: 25px;"></i></p>
                <p class="text-gray-700" > جمعنا فريق عمل متخصص لكل فرد في الفريق مهامه الخاصة مما يضمن جودة كل عناصر المشروع, والسرعة في الإنجاز, كما نعمل وفق معايير محددة تم درساتها مسبقا تضمن جودة المنتج العالية</p>

                <p class="text-gray-700" style="font-size: 25px;"> الشغف بالمجال <i class="fas fa-caret-left" style="color: #5a67d8;font-size: 25px;"></i></p>
                <p class="text-gray-700" >نحن نعتبر البرمجة اكثر من مجرد عمل, بل هي وسيلة للإبداع وتحويل الأفكار إلى واقع وهذا يخلق بداخل الفريق شغف ومتعة في إنتاج برمجيات ذات جودة عالية ولها القدرة على المنافسة في السوق, كذلك نوفر بيئة مريحة لفريق العمل تساعد في الإنتاج</p>
            </div>
        </div>

        <div class="sm:w-1/2 p-10">
            <div class="image object-center text-center">
                <img src="https://www.htmlden.com/wp-content/themes/ks/img/web-developer-master-tn.svg">
            </div>
        </div>

    </div>

</div>
@endsection

@section('js')

@endsection


@section('script')

@endsection
