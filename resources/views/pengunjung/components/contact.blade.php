<section id="contact" class="section">
    <div class="container">
        <div class="row mb-5 align-items-end">
            <div class="col-md-6" data-aos="fade-up">
                <h2>Kontak</h2>
            </div>

        </div>

        <div class="row">
            <div class="col-md-4 ms-auto order-2" data-aos="fade-up">
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <strong class="d-block mb-1">Address</strong>
                        <span>Jl. Lohbener Lama No 08 Kec. Lohbener Kab. Indramayu Jawa
                            Barat 45
                            </span>
                    </li>
                    <li class="mb-3">
                        <strong class="d-block mb-1">Phone</strong>
                        <span>089639490563</span>
                    </li>
                    <li class="mb-3">
                        <strong class="d-block mb-1">Email</strong>
                        <span>gouma@gmail.com</span>
                    </li>
                </ul>
            </div>

            <div class="col-md-6 mb-5 mb-md-0" data-aos="fade-up">
                @include('layouts.components.flash')
                <form action="{{route('contact.send')}}" method="post" role="form" class="php-email-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <label for="name">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="col-md-12 form-group mt-3">
                            <label for="name">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject" required>
                        </div>
                        <div class="col-md-12 form-group mt-3">
                            <label for="name">Message</label>
                            <textarea class="form-control" name="msg" required></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>

                        <div class="col-md-6 form-group">
                            <input type="submit" class="btn btn-primary d-block w-100" value="Send Message">
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</section>