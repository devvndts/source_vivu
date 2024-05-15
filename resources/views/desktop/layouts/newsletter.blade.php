<form class="d-flex footer__newletter mb-4 frm_newsletter //frm_check_recaptcha" action="{{route('sendNewsletter')}}" method="post">
    @csrf
    <input type="email" name="email" placeholder="Your email address" required>
    <input type="hidden" name="type" value="dangkynhanvoucher" />
    <input type="hidden" name="isrecaptcha" value="0" />
    <button type="submit"><i class="fas fa-paper-plane"></i></button>
</form>