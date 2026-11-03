<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vastrkaya')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Main Application CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="site-wrapper d-flex flex-column min-vh-100">
        
        @if (isset($show_navbar))
            @include('partials.navbar')
        @endif


        <main class="flex-grow-1">
            @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-3" role="alert">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @yield('hero-section')
        </main>

        @if (isset($show_footer))
            @include('partials.footer')
        @endif
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

<script>
    document.addEventListener('DOMContentLoaded',function () {
        axios.get('/cart')
        .then((res)=> {
            let data = res.data;
            if (!data || !data.success) return;

            let totalCount = parseInt(data.total_quantity ?? 0);    
            
            $('#navCartBadge').text(totalCount);
        })
        .catch(err => {
            console.error(err);
        });

        
        $(document).on('click','.search-category',function(e) {

            e.preventDefault();
            
            let id = $(this).data('id');
            
            $('.category_div').removeClass('highlight');

            let c_div = $('#category_id_'+id);

            if(c_div.length > 0) {
                
                c_div[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                c_div.addClass('highlight');

                setTimeout(function () {
                    c_div.removeClass('highlight');
                },3000);
            }
        })

        
        $(document).on('input','.main-search',function(e) {

            let row = '';

            console.log( $(this).val());
            
            
            $('#searchDropdown').removeClass('d-none');
            
            axios.post('/main-search',{search: e.target.value})
            .then((res)=> {
                let data = res.data;
                if(data.success){
                    if (data.products.length > 0) {
                        row += `<div class="search-heading">Products</div><ul class="vk-search-list">`;

                        data.products.forEach((product) => {
                            row += `
                                <li>
                                    <a href="/products/${product.id}" class="vk-search-link">
                                        ${product.name}
                                    </a>
                                </li>
                            `;
                        });

                        row += `</ul>`;
                    }

                    if (data.categories.length > 0) {
                        row += `<div class="search-heading">Categories</div><ul class="vk-search-list">`;

                        data.categories.forEach((category) => {
                            row += `
                                <li>
                                    <a href="javascript:void(0)"
                                    data-id="${category.id}"
                                    class="search-category vk-search-link">
                                        ${category.name}
                                    </a>
                                </li>
                            `;
                        });

                        row += `</ul>`;
                    }

                    if (data.coupons.length > 0) {
                        row += `<div class="search-heading">Coupons</div><ul class="vk-search-list">`;

                        data.coupons.forEach((coupon) => {
                            row += `
                                <li>
                                    <a href="/cart" class="vk-search-link">
                                        ${coupon.coupon_name}
                                    </a>
                                </li>
                            `;
                        });

                        row += `</ul>`;
                    }
                    
                }
                $('#searchDropdownContent').html(row);
                
            })
            .catch((err)=> {
                
            })
            
        });

        
        $('.main-search').on('blur',function(e) {

            setTimeout(function() {
                $('#searchDropdown').addClass('d-none');
            }, 2000);   
            
            $(this).val('');
            
        })
    });

    
</script>

@yield('script')

</html>
