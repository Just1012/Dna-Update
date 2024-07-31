
<style>#scrollToTopBtn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    display: none; /* Initially hidden */
    border: none;
    background-color: #295e4e;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: opacity 0.3s ease-in-out;
}

#scrollToTopBtn:hover {
    background-color: #327561;
}
</style>

<button id="scrollToTopBtn" class="btn btn-primary" style="display: none;  backgroud:#295e4e">
    <i class="ri-arrow-up-line"></i>

</button>

<script>
    // Get the button
    var scrollToTopBtn = document.getElementById('scrollToTopBtn');

    // Show or hide the button based on scroll position
    window.onscroll = function() {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
    };

    // Smooth scroll to top on button click
    scrollToTopBtn.onclick = function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };
</script>
