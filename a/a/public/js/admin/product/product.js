const Product = (function () {
    let modules = {};

    modules.previewImage = function (input, img) {
        const reader = new FileReader();
        reader.onload = function (e) {
            img.attr("src", e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    };

    modules.uploadMutipleImage = function (input, url) {
        const imagesLength = input.files.length;
        const imagesInsertedHtmlLength = $('.place-to-insert-images').find('.images-product').length
        const isFullImages = imagesLength > 4 || imagesInsertedHtmlLength >= 4
        if (isFullImages) return toastr.error(`tối đa là 4 ảnh!!`);

        const formData = new FormData();
        for(let i = 0; i < imagesLength; i++) {
            formData.append('images[]', input.files[i]);
        }

        callAjaxWithFormData(url, formData)
            .done(function (res) {
                if(res.status === 200) {
                    let html = res.images.map(image => {
                        return Product.renderImageHTML(`/uploads/${image}`, image)
                    })

                    $('.content-images').append(html.join(''));
                    const inputImageMultiple = $(`input[name="image-multiple"]`)
                    const arrayInputImageMultiple = JSON.parse(inputImageMultiple.val());
                    arrayInputImageMultiple.push(...res.images)
                    inputImageMultiple.val(JSON.stringify(arrayInputImageMultiple))
                }
            })
    };

    modules.renderImageHTML = function (src, imageName) {
        return `<div class="col-sm-3 col-sx-3 col-3 col-lg-3 wrapper-image">
                    <button class="remove-image" type="button" data-image-name="${imageName}">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <img src="${src}" class="images-product" alt="image des">
                </div>`;
    };

    return modules;
})(window.jQuery, window, document);

$(function () {
    //multiple select categories
    $("#categories-product").selectpicker();
    const thumbNailInput = $(`input[name="image"]`);
    const thumbNailMutipleImage = $('#image-multiple');
    const contentImages = $('.content-images');

    thumbNailInput.on("change", function (e) {
        const img = $(".preview-thumbnail > img");
        Product.previewImage(this, img);
    });

    thumbNailMutipleImage.on("change", function (e) {
        const url = $(this).data('route');
        Product.uploadMutipleImage(this, url);
    });

    contentImages.on('click', '.remove-image', function() {
        $(this).parent().remove();
        const inputImageMultiple = $(`input[name="image-multiple"]`);
        const imageName = $(this).data('image-name');
        const arrayInputImageMultiple = JSON.parse(inputImageMultiple.val());
        const arrayInputImageMultipleFilter = arrayInputImageMultiple.filter(image => image !== imageName);
        inputImageMultiple.val(JSON.stringify(arrayInputImageMultipleFilter));

        if($(this).hasClass('edit')) {
            const imageId = $(this).data('image-id');
            const inputImageId = $(`input[name="image-id"]`);
            const arrayImageId = JSON.parse(inputImageId.val())
            inputImageId.val(JSON.stringify([...arrayImageId, imageId]))
        }
    });
});
