@extends('layouts.guest')

@section('content')
<div>
    <x-banner2 page="Terms & Conditions" breadcrumb="Properties" img="img/properties/page-header.png" />
</div>

<section class="bg-[#e8e8e8] pt-20 pb-[20rem]">
    <div class="max-w-screen-lg px-6 mx-auto bg-white shadow-md rounded-md p-10 leading-relaxed text-gray-800">
        <h1 class="text-3xl font-bold text-[#253e16] mb-6">Terms and Conditions</h1>

        <p><strong>Effective Date:</strong> </p>

        <p class="mt-4">
            Welcome to Architex Phil., Inc. These Terms and Conditions outline the rules and regulations for the use of our
            website at <em>https://architex.rwebserver.com/</em>. By accessing or using this Website, you agree to be bound by these Terms and
            Conditions in full. If you do not agree with any part of these terms, please refrain from using our Website.
        </p>

        <hr class="my-8 border-gray-300">

        <h2 class="text-2xl font-semibold mt-8 mb-4">1. Acceptance of Terms</h2>
        <p>
            By accessing and using this Website, you agree to comply with these Terms and Conditions and all applicable laws
            and regulations in the Republic of the Philippines, including the Data Privacy Act of 2012 (Republic Act No. 10173).
        </p>

        <hr class="my-8 border-gray-300">

        <h2 class="text-2xl font-semibold mt-8 mb-4">2. Use of the Website</h2>
        <p>You agree to use this Website only for lawful and legitimate purposes related to Architex Phil., Inc.’s business operations. You must not:</p>
        <ul class="list-disc ml-6 mt-2">
            <li>Violate any applicable Philippine or international laws.</li>
            <li>Interfere with or disrupt the proper functioning of the Website.</li>
            <li>Attempt to access restricted, private, or unauthorized areas of the Website.</li>
            <li>Submit false, misleading, or fraudulent information through any form or transaction.</li>
        </ul>

        <hr class="my-8 border-gray-300">

        <h2 class="text-2xl font-semibold mt-8 mb-4">3. Intellectual Property Rights</h2>
        <p>
            All content on this Website—including but not limited to text, images, property renderings, architectural designs,
            graphics, and logos—is the intellectual property of Architex Phil., Inc. and is protected under Philippine copyright
            and intellectual property laws.
        </p>
        <p class="mt-2">
            You may not reproduce, copy, distribute, modify, or use any content from this Website without our prior written consent.
        </p>

        <hr class="my-8 border-gray-300">

        <h2 class="text-2xl font-semibold mt-8 mb-4">4. Property Information and Pricing</h2>
        <p>
            We strive to provide accurate and updated information on all properties, project details, pricing, and availability.
            However, Architex Phil., Inc. does not guarantee that all information on the Website is always complete, accurate, or up to date.
        </p>
        <p class="mt-2">
            Prices, availability, terms, and property features may change without prior notice.
        </p>

        <hr class="my-8 border-gray-300">

        <h2 class="text-2xl font-semibold mt-8 mb-4">5. Reservations, Rentals, and Transactions</h2>
        <p>All reservations, payments, or service requests made through the Website are subject to confirmation and availability. By proceeding with a reservation or transaction, you agree to:</p>
        <ul class="list-disc ml-6 mt-2">
            <li>Provide accurate and complete information.</li>
            <li>Authorize Architex Phil., Inc. and its payment partners (PayMongo or Dragonpay) to process payments securely.</li>
            <li>Acknowledge that any reservation fee or payment made may be subject to company terms, including non-refundable policies where applicable.</li>
        </ul>
        <p class="mt-2">
            We reserve the right to refuse, cancel, or modify any transaction at our discretion if suspicious, unauthorized,
            or inconsistent information is detected.
        </p>

        <hr class="my-8 border-gray-300">

        <h2 class="text-2xl font-semibold mt-8 mb-4">6. Data Privacy and Protection</h2>
        <p>
            We collect and process personal data in compliance with the Data Privacy Act of 2012 and its Implementing Rules and
            Regulations. By using this Website and submitting your personal information, you consent to the collection, use,
            storage, and processing of your data for legitimate business purposes such as:
        </p>
        <ul class="list-disc ml-6 mt-2">
            <li>Handling inquiries and client communication</li>
            <li>Processing reservations, rentals, and payments</li>
            <li>Managing customer relations and CRM records</li>
            <li>Sending updates, newsletters, and promotional materials (if you have opted in)</li>
            <li>Improving our Website and services</li>
        </ul>

        <p class="mt-4">
            We take reasonable measures to protect your personal data from unauthorized access or disclosure.
            For more details, please refer to our
            <a href="{{ route('privacy') }}" class="text-green-700 font-medium underline hover:text-green-900">Privacy Policy</a>.
        </p>

        <hr class="my-8 border-gray-300">

        <h2 class="text-2xl font-semibold mt-8 mb-4">7. Cookies</h2>
        <p>
            Our Website may use cookies and similar technologies to enhance user experience and analyze site traffic.
            By continuing to browse our Website, you consent to the use of cookies in accordance with our Cookie Policy.
        </p>

        <hr class="my-8 border-gray-300">

        <h2 class="text-2xl font-semibold mt-8 mb-4">8. Third-Party Links and Services</h2>
        <p>
            Our Website may include links to our official social media accounts such as Facebook, Instagram, YouTube, TikTok,
            and LinkedIn, as well as external platforms like PayMongo and Dragonpay for secure payment processing.
        </p>
        <p class="mt-2">
            These third-party sites and services operate under their own privacy policies and data handling practices. Architex Phil., Inc.
            is not responsible for the content, security, or practices of these external platforms.
        </p>

        <hr class="my-8 border-gray-300">

        <h2 class="text-2xl font-semibold mt-8 mb-4">9. Limitation of Liability</h2>
        <p>
            To the fullest extent permitted by law, Architex Phil., Inc. shall not be held liable for any loss, damage, or inconvenience
            arising from your use or inability to use this Website, including reliance on any information, delays, or technical errors.
            Use of the Website and participation in any transaction are at your own risk.
        </p>

        <hr class="my-8 border-gray-300">

        <h2 class="text-2xl font-semibold mt-8 mb-4">10. Changes to Terms</h2>
        <p>
            Architex Phil., Inc. may update or modify these Terms and Conditions at any time without prior notice.
            Changes will take effect once posted on this page. Continued use of the Website after updates are posted constitutes your acceptance
            of the revised Terms.
        </p>

        <hr class="my-8 border-gray-300">

        <h2 class="text-2xl font-semibold mt-8 mb-4">11. Governing Law</h2>
        <p>
            These Terms and Conditions shall be governed and interpreted under the laws of the Republic of the Philippines.
            Any disputes shall be resolved in the appropriate courts located in Davao City, Philippines.
        </p>

        <hr class="my-8 border-gray-300">

        <h2 class="text-2xl font-semibold mt-8 mb-4">12. Contact Information</h2>
        <p>
            For questions, feedback, or concerns regarding these Terms and Conditions or our data practices, please contact us at:
        </p>
        <p class="mt-4">
            <strong>Architex Phil., Inc.</strong><br>
            Website: <em>[insert website URL]</em><br>
            Email: <a href="mailto:info@architexphil.com" class="text-green-700 underline">info@architexphil.com</a><br>
            Phone: <strong>0927 725 7326</strong>
        </p>
    </div>
</section>
@endsection