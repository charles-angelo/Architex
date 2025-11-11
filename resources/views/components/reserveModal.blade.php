<div x-data="modal()" x-cloak x-init="$watch('open', value => {
    if (value) {
        document.body.classList.add('overflow-hidden');
        document.documentElement.classList.add('overflow-hidden');
    } else {
        document.body.classList.remove('overflow-hidden');
        document.documentElement.classList.remove('overflow-hidden');
    }
})">

    <!-- Trigger Button -->
    <button @click="open = true" class="bg-[#253e16] px-5 py-3 text-white">
        Reserve Now
    </button>

    <template x-teleport="body">
        <div x-show="open" x-cloak x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.outside="open = false"
                class="w-full max-w-3xl mx-4 overflow-hidden bg-white shadow-lg rounded-xl">

                <!-- Header -->
                <div class="p-6 border-b" x-show="!paymentSuccess" x-transition>
                    <h2 class="text-2xl font-bold text-[#1E4D2B]">RESERVE YOUR LOT</h2>
                    <div class="flex items-center mt-2 space-x-3 text-sm">
                        <span :class="step === 1 ? 'text-[#1E4D2B] font-semibold' : 'text-gray-400'">
                            ● Step 1: Personal Information
                        </span>
                        <span :class="step === 2 ? 'text-[#1E4D2B] font-semibold' : 'text-gray-400'">
                            ● Step 2: Payment Method
                        </span>
                    </div>
                </div>

                <!-- STEP 1 -->
                <div x-show="step === 1 && !paymentSuccess" x-transition
                    class="p-6 space-y-6 overflow-y-auto max-h-[80vh]">
                    <!-- Lot Details -->
                    <div x-show="activeLot" x-transition>
                        <div class="bg-[#d3e3d5] text-[#1E4D2B] px-4 py-2 font-semibold rounded-t-md">
                            Lot Details
                        </div>
                        <div class="flex gap-4 p-4 border rounded-b-md">
                            <img
                                x-show="activeLot"
                                :src="activeLot?.house_details?.length 
                                    ? activeLot.house_details[0] 
                                    : '{{ asset($property['house'] ?? 'img/default-house.jpg') }}'"
                                alt="Property"
                                class="object-cover w-32 h-32 rounded-md transition-all duration-500 ease-in-out" />
                            <div class="space-y-1 text-sm">
                                <h3 class="font-bold text-lg text-[#1E4D2B]" x-text="activeLot.name ?? 'No Lot Selected'"></h3>
                                <p>Lot Selected: <span x-text="activeLot.address ?? '-'"></span></p>
                                <p>Lot Area: <span x-text="`${activeLot.size ?? 0}`"></span></p>
                                <p>Type: <span x-text="activeLot.type ?? 'N/A'"></span></p>
                                <p class="font-semibold">
                                    <span x-text="activeLot?.price 
                            ? `Price: ${activeLot.price.toLocaleString()}` 
                            : 'Price: N/A'"></span>

                                </p>
                                <p>Status:
                                    <span :class="{
                                        'text-green-700 font-semibold': activeLot.status === 'Available',
                                        'text-yellow-500 font-semibold': activeLot.status === 'Reserved',
                                        'text-red-600 font-semibold': activeLot.status === 'Sold'
                                    }" x-text="activeLot.status ?? 'Unknown'"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Details -->
                    <div>
                        <h4 class="text-[#1E4D2B] font-semibold mb-3">Personal Details</h4>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <input type="text" placeholder="Full Name*" x-model="fullName"
                                    :class="error.fullName ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#1E4D2B]'"
                                    class="p-3 border rounded-md w-full focus:outline-none">
                                <p x-show="error.fullName" class="text-red-500 text-sm mt-1" x-text="error.fullName"></p>
                            </div>
                            <div>
                                <input type="text" placeholder="Contact Number*" x-model="contactNumber"
                                    :class="error.contactNumber ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#1E4D2B]'"
                                    class="p-3 border rounded-md w-full focus:outline-none">
                                <p x-show="error.contactNumber" class="text-red-500 text-sm mt-1" x-text="error.contactNumber"></p>
                            </div>
                            <div>
                                <input type="email" placeholder="Email Address*" x-model="email"
                                    :class="error.email ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#1E4D2B]'"
                                    class="p-3 border rounded-md w-full focus:outline-none">
                                <p x-show="error.email" class="text-red-500 text-sm mt-1" x-text="error.email"></p>
                            </div>
                            <div>
                                <input type="text" placeholder="Tel. Number (optional)" x-model="telephoneNumber"
                                    class="p-3 border border-gray-300 rounded-md w-full focus:ring-[#1E4D2B] focus:border-[#1E4D2B]">
                            </div>
                        </div>

                        <!-- Checkboxes -->
                        <div class="mt-4 space-y-2 text-sm mb-6" x-data="{ showTermsModal: false, canAgree: false }">
                            <!-- Terms & Privacy Checkbox -->
                            <label class="flex items-start space-x-2 cursor-pointer">
                                <input type="checkbox" class="mt-1" x-model="termsAccepted" @click.prevent="showTermsModal = true">
                                <span>
                                    I agree to the
                                    <a href="#" class="text-[#1E4D2B] underline">Terms & Conditions</a>
                                    and the
                                    <a href="#" class="text-[#1E4D2B] underline">Privacy Policy</a>.
                                </span>
                            </label>
                            <p x-show="error.terms" class="text-red-500 text-sm mt-1" x-text="error.terms"></p>

                            <!-- Confirmation Checkbox -->
                            <label class="flex items-start space-x-2">
                                <input type="checkbox" class="mt-1" x-model="confirmationAccepted">
                                <span>
                                    I confirm that the details provided are true and correct, and I understand that this
                                    reservation is subject to approval.
                                </span>
                            </label>
                            <p x-show="error.confirmation" class="text-red-500 text-sm mt-1" x-text="error.confirmation"></p>

                            <!-- Terms Modal -->
                            <div x-show="showTermsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-transition>
                                <div class="bg-white w-11/12 md:w-3/4 lg:w-1/2 max-h-[80vh] overflow-hidden p-6 rounded-lg shadow-lg relative">

                                    <!-- Close Button -->
                                    <button @click="showTermsModal = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl">&times;</button>

                                    <!-- Scrollable Terms & Privacy -->
                                    <div class="overflow-y-auto max-h-[65vh] pr-2" @scroll="canAgree = ($event.target.scrollTop + $event.target.clientHeight) >= $event.target.scrollHeight">
                                        <!-- Terms & Conditions -->
                                        <h2 class="font-bold mb-4 text-2xl">Terms & Conditions</h2>
                                        <p><strong>Effective Date:</strong> </p>

                                        <p class="mt-4">
                                            Welcome to Architex Phil., Inc. These Terms and Conditions outline the rules and regulations for the use of
                                            our
                                            website at <em>https://architex.rwebserver.com/</em>. By accessing or using this Website, you agree to be
                                            bound by these Terms and
                                            Conditions in full. If you do not agree with any part of these terms, please refrain from using our Website.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">1. Acceptance of Terms</h2>
                                        <p>
                                            By accessing and using this Website, you agree to comply with these Terms and Conditions and all applicable
                                            laws
                                            and regulations in the Republic of the Philippines, including the Data Privacy Act of 2012 (Republic Act No.
                                            10173).
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">2. Use of the Website</h2>
                                        <p>You agree to use this Website only for lawful and legitimate purposes related to Architex Phil., Inc.’s
                                            business operations. You must not:</p>
                                        <ul class="mt-2 ml-6 list-disc">
                                            <li>Violate any applicable Philippine or international laws.</li>
                                            <li>Interfere with or disrupt the proper functioning of the Website.</li>
                                            <li>Attempt to access restricted, private, or unauthorized areas of the Website.</li>
                                            <li>Submit false, misleading, or fraudulent information through any form or transaction.</li>
                                        </ul>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">3. Intellectual Property Rights</h2>
                                        <p>
                                            All content on this Website—including but not limited to text, images, property renderings, architectural
                                            designs,
                                            graphics, and logos—is the intellectual property of Architex Phil., Inc. and is protected under Philippine
                                            copyright
                                            and intellectual property laws.
                                        </p>
                                        <p class="mt-2">
                                            You may not reproduce, copy, distribute, modify, or use any content from this Website without our prior
                                            written consent.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">4. Property Information and Pricing</h2>
                                        <p>
                                            We strive to provide accurate and updated information on all properties, project details, pricing, and
                                            availability.
                                            However, Architex Phil., Inc. does not guarantee that all information on the Website is always complete,
                                            accurate, or up to date.
                                        </p>
                                        <p class="mt-2">
                                            Prices, availability, terms, and property features may change without prior notice.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">5. Reservations, Rentals, and Transactions</h2>
                                        <p>All reservations, payments, or service requests made through the Website are subject to confirmation and
                                            availability. By proceeding with a reservation or transaction, you agree to:</p>
                                        <ul class="mt-2 ml-6 list-disc">
                                            <li>Provide accurate and complete information.</li>
                                            <li>Authorize Architex Phil., Inc. and its payment partners (PayMongo or Dragonpay) to process payments
                                                securely.</li>
                                            <li>Acknowledge that any reservation fee or payment made may be subject to company terms, including
                                                non-refundable policies where applicable.</li>
                                        </ul>
                                        <p class="mt-2">
                                            We reserve the right to refuse, cancel, or modify any transaction at our discretion if suspicious,
                                            unauthorized,
                                            or inconsistent information is detected.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">6. Data Privacy and Protection</h2>
                                        <p>
                                            We collect and process personal data in compliance with the Data Privacy Act of 2012 and its Implementing
                                            Rules and
                                            Regulations. By using this Website and submitting your personal information, you consent to the collection,
                                            use,
                                            storage, and processing of your data for legitimate business purposes such as:
                                        </p>
                                        <ul class="mt-2 ml-6 list-disc">
                                            <li>Handling inquiries and client communication</li>
                                            <li>Processing reservations, rentals, and payments</li>
                                            <li>Managing customer relations and CRM records</li>
                                            <li>Sending updates, newsletters, and promotional materials (if you have opted in)</li>
                                            <li>Improving our Website and services</li>
                                        </ul>

                                        <p class="mt-4">
                                            We take reasonable measures to protect your personal data from unauthorized access or disclosure.
                                            For more details, please refer to our
                                            <a href="{{ route('privacy') }}" class="font-medium text-green-700 underline hover:text-green-900">Privacy
                                                Policy</a>.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">7. Cookies</h2>
                                        <p>
                                            Our Website may use cookies and similar technologies to enhance user experience and analyze site traffic.
                                            By continuing to browse our Website, you consent to the use of cookies in accordance with our Cookie Policy.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">8. Third-Party Links and Services</h2>
                                        <p>
                                            Our Website may include links to our official social media accounts such as Facebook, Instagram, YouTube,
                                            TikTok,
                                            and LinkedIn, as well as external platforms like PayMongo and Dragonpay for secure payment processing.
                                        </p>
                                        <p class="mt-2">
                                            These third-party sites and services operate under their own privacy policies and data handling practices.
                                            Architex Phil., Inc.
                                            is not responsible for the content, security, or practices of these external platforms.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">9. Limitation of Liability</h2>
                                        <p>
                                            To the fullest extent permitted by law, Architex Phil., Inc. shall not be held liable for any loss, damage,
                                            or inconvenience
                                            arising from your use or inability to use this Website, including reliance on any information, delays, or
                                            technical errors.
                                            Use of the Website and participation in any transaction are at your own risk.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">10. Changes to Terms</h2>
                                        <p>
                                            Architex Phil., Inc. may update or modify these Terms and Conditions at any time without prior notice.
                                            Changes will take effect once posted on this page. Continued use of the Website after updates are posted
                                            constitutes your acceptance
                                            of the revised Terms.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">11. Governing Law</h2>
                                        <p>
                                            These Terms and Conditions shall be governed and interpreted under the laws of the Republic of the
                                            Philippines.
                                            Any disputes shall be resolved in the appropriate courts located in Davao City, Philippines.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">12. Contact Information</h2>
                                        <p>
                                            For questions, feedback, or concerns regarding these Terms and Conditions or our data practices, please
                                            contact us at:
                                        </p>
                                        <p class="mt-4">
                                            <strong>Architex Phil., Inc.</strong><br>
                                            Website: <em>[insert website URL]</em><br>
                                            Email: <a href="mailto:info@architexphil.com" class="text-green-700 underline">info@architexphil.com</a><br>
                                            Phone: <strong>0927 725 7326</strong>
                                        </p>
                                        <hr class="my-4">

                                        <!-- Privacy Policy -->
                                        <h2 class="font-bold mb-4 text-2xl">Privacy Policy</h2>
                                        <p><strong>Effective Date:</strong> </p>

                                        <p class="mt-4">
                                            Welcome to Architex Phil., Inc. These Terms and Conditions outline the rules and regulations for the use of
                                            our
                                            website at <em>https://architex.rwebserver.com/</em>. By accessing or using this Website, you agree to be
                                            bound by these Terms and
                                            Conditions in full. If you do not agree with any part of these terms, please refrain from using our Website.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">1. Acceptance of Terms</h2>
                                        <p>
                                            By accessing and using this Website, you agree to comply with these Terms and Conditions and all applicable
                                            laws
                                            and regulations in the Republic of the Philippines, including the Data Privacy Act of 2012 (Republic Act No.
                                            10173).
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">2. Use of the Website</h2>
                                        <p>You agree to use this Website only for lawful and legitimate purposes related to Architex Phil., Inc.’s
                                            business operations. You must not:</p>
                                        <ul class="mt-2 ml-6 list-disc">
                                            <li>Violate any applicable Philippine or international laws.</li>
                                            <li>Interfere with or disrupt the proper functioning of the Website.</li>
                                            <li>Attempt to access restricted, private, or unauthorized areas of the Website.</li>
                                            <li>Submit false, misleading, or fraudulent information through any form or transaction.</li>
                                        </ul>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">3. Intellectual Property Rights</h2>
                                        <p>
                                            All content on this Website—including but not limited to text, images, property renderings, architectural
                                            designs,
                                            graphics, and logos—is the intellectual property of Architex Phil., Inc. and is protected under Philippine
                                            copyright
                                            and intellectual property laws.
                                        </p>
                                        <p class="mt-2">
                                            You may not reproduce, copy, distribute, modify, or use any content from this Website without our prior
                                            written consent.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">4. Property Information and Pricing</h2>
                                        <p>
                                            We strive to provide accurate and updated information on all properties, project details, pricing, and
                                            availability.
                                            However, Architex Phil., Inc. does not guarantee that all information on the Website is always complete,
                                            accurate, or up to date.
                                        </p>
                                        <p class="mt-2">
                                            Prices, availability, terms, and property features may change without prior notice.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">5. Reservations, Rentals, and Transactions</h2>
                                        <p>All reservations, payments, or service requests made through the Website are subject to confirmation and
                                            availability. By proceeding with a reservation or transaction, you agree to:</p>
                                        <ul class="mt-2 ml-6 list-disc">
                                            <li>Provide accurate and complete information.</li>
                                            <li>Authorize Architex Phil., Inc. and its payment partners (PayMongo or Dragonpay) to process payments
                                                securely.</li>
                                            <li>Acknowledge that any reservation fee or payment made may be subject to company terms, including
                                                non-refundable policies where applicable.</li>
                                        </ul>
                                        <p class="mt-2">
                                            We reserve the right to refuse, cancel, or modify any transaction at our discretion if suspicious,
                                            unauthorized,
                                            or inconsistent information is detected.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">6. Data Privacy and Protection</h2>
                                        <p>
                                            We collect and process personal data in compliance with the Data Privacy Act of 2012 and its Implementing
                                            Rules and
                                            Regulations. By using this Website and submitting your personal information, you consent to the collection,
                                            use,
                                            storage, and processing of your data for legitimate business purposes such as:
                                        </p>
                                        <ul class="mt-2 ml-6 list-disc">
                                            <li>Handling inquiries and client communication</li>
                                            <li>Processing reservations, rentals, and payments</li>
                                            <li>Managing customer relations and CRM records</li>
                                            <li>Sending updates, newsletters, and promotional materials (if you have opted in)</li>
                                            <li>Improving our Website and services</li>
                                        </ul>

                                        <p class="mt-4">
                                            We take reasonable measures to protect your personal data from unauthorized access or disclosure.
                                            For more details, please refer to our
                                            <a href="{{ route('privacy') }}" class="font-medium text-green-700 underline hover:text-green-900">Privacy
                                                Policy</a>.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">7. Cookies</h2>
                                        <p>
                                            Our Website may use cookies and similar technologies to enhance user experience and analyze site traffic.
                                            By continuing to browse our Website, you consent to the use of cookies in accordance with our Cookie Policy.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">8. Third-Party Links and Services</h2>
                                        <p>
                                            Our Website may include links to our official social media accounts such as Facebook, Instagram, YouTube,
                                            TikTok,
                                            and LinkedIn, as well as external platforms like PayMongo and Dragonpay for secure payment processing.
                                        </p>
                                        <p class="mt-2">
                                            These third-party sites and services operate under their own privacy policies and data handling practices.
                                            Architex Phil., Inc.
                                            is not responsible for the content, security, or practices of these external platforms.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">9. Limitation of Liability</h2>
                                        <p>
                                            To the fullest extent permitted by law, Architex Phil., Inc. shall not be held liable for any loss, damage,
                                            or inconvenience
                                            arising from your use or inability to use this Website, including reliance on any information, delays, or
                                            technical errors.
                                            Use of the Website and participation in any transaction are at your own risk.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">10. Changes to Terms</h2>
                                        <p>
                                            Architex Phil., Inc. may update or modify these Terms and Conditions at any time without prior notice.
                                            Changes will take effect once posted on this page. Continued use of the Website after updates are posted
                                            constitutes your acceptance
                                            of the revised Terms.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">11. Governing Law</h2>
                                        <p>
                                            These Terms and Conditions shall be governed and interpreted under the laws of the Republic of the
                                            Philippines.
                                            Any disputes shall be resolved in the appropriate courts located in Davao City, Philippines.
                                        </p>

                                        <hr class="my-8 border-gray-300">

                                        <h2 class="mt-8 mb-4 text-2xl font-semibold">12. Contact Information</h2>
                                        <p>
                                            For questions, feedback, or concerns regarding these Terms and Conditions or our data practices, please
                                            contact us at:
                                        </p>
                                        <p class="mt-4">
                                            <strong>Architex Phil., Inc.</strong><br>
                                            Website: <em>[insert website URL]</em><br>
                                            Email: <a href="mailto:info@architexphil.com" class="text-green-700 underline">info@architexphil.com</a><br>
                                            Phone: <strong>0927 725 7326</strong>
                                        </p>
                                    </div>

                                    <!-- Accept Button -->
                                    <div class="text-right mt-4">
                                        <button
                                            :disabled="!canAgree"
                                            @click="termsAccepted = true; showTermsModal = false"
                                            :class="{'bg-gray-400 cursor-not-allowed': !canAgree, 'bg-[#1E4D2B] hover:bg-[#163a1b] text-white': canAgree}"
                                            class="px-4 py-2 rounded">
                                            I Agree
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{-- ✅ Google reCAPTCHA --}}
                            <div class="mb-6">
                                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITEKEY') }}"></div>
                                @error('g-recaptcha-response')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 1 Footer -->
                <div x-show="step === 1 && !paymentSuccess" x-transition
                    class="flex items-center justify-between px-6 py-5 border-t bg-gray-50">
                    <button @click="open = false"
                        class="text-[#1E4D2B] font-medium flex items-center space-x-2 hover:underline">
                        Cancel Reservation
                    </button>

                    <button @click="validateAndProceed" class="bg-[#1E4D2B] text-white px-6 py-2 rounded-md hover:bg-[#16381f]">
                        Proceed to Payment
                    </button>
                </div>

                <!-- STEP 2 -->
                <form
                    x-show="step === 2 && !paymentSuccess"
                    x-transition
                    action="{{ route('payments.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="p-6 space-y-6 overflow-y-auto max-h-[80vh]">
                    @csrf
                    <input type="hidden" name="lot_id" :value="activeLot?.id ?? ''">
                    <input type="hidden" name="full_name" x-model="fullName">
                    <input type="hidden" name="email" x-model="email">
                    <input type="hidden" name="contact_number" x-model="contactNumber">
                    <input type="hidden" name="telephone_number" x-model="telephoneNumber">
                    <input type="hidden" name="total" :value="activeLot?.price ?? 0">

                    <!-- 👇 Hidden status based on payment type -->
                    <input type="hidden" name="status" :value="paymentType === 'full' ? 'paid' : 'partial'">

                    <div class="bg-[#d3e3d5] text-[#1E4D2B] px-4 py-2 font-semibold rounded-md">
                        Select Payment Amount:
                    </div>

                    <div class="flex gap-4 mt-2">
                        <label class="flex-1 cursor-pointer border rounded-md p-4 text-center"
                            :class="paymentType === 'partial' ? 'border-[#1E4D2B] bg-[#e2f1e6]' : ''">
                            <input type="radio" value="partial" x-model="paymentType" class="hidden">
                            <div class="font-semibold">Partial Down Payment</div>
                            <div class="text-sm text-gray-600">₱50,000</div>
                        </label>

                        <label class="flex-1 cursor-pointer border rounded-md p-4 text-center"
                            :class="paymentType === 'full' ? 'border-[#1E4D2B] bg-[#e2f1e6]' : ''">
                            <input type="radio" value="full" x-model="paymentType" class="hidden">
                            <div class="font-semibold">Full Payment</div>
                            <div class="text-sm text-gray-600"
                                x-text="`${activeLot?.price?.toLocaleString() ?? 0}`">
                            </div>
                        </label>
                    </div>

                    <div>
                        <h4 class="text-[#1E4D2B] font-semibold mb-3">Payment Method</h4>
                        <div class="space-y-4" x-data="{ selectedMethod: 'gcash' }">
                            <!-- GCash -->
                            <label class="flex items-start p-4 space-x-3 border rounded-md cursor-pointer"
                                :class="selectedMethod === 'gcash' ? 'border-[#1E4D2B] bg-[#e2f1e6]' : ''">
                                <input type="radio" name="payment_method" value="gcash"
                                    x-model="selectedMethod" class="mt-1 text-[#1E4D2B]">
                                <div>
                                    <p class="font-semibold text-[#1E4D2B]">GCash</p>
                                    <p class="text-sm text-gray-600">Pay easily using your GCash account.</p>
                                </div>
                            </label>

                            <!-- PayMaya -->
                            <label class="flex items-start p-4 space-x-3 border rounded-md cursor-pointer"
                                :class="selectedMethod === 'paymaya' ? 'border-[#1E4D2B] bg-[#e2f1e6]' : ''">
                                <input type="radio" name="payment_method" value="paymaya"
                                    x-model="selectedMethod" class="mt-1 text-[#1E4D2B]">
                                <div>
                                    <p class="font-semibold text-[#1E4D2B]">PayMaya</p>
                                    <p class="text-sm text-gray-600">Use your PayMaya account to complete payment.</p>
                                </div>
                            </label>

                            <!-- Pay Later -->
                            <label class="flex items-start p-4 space-x-3 border rounded-md cursor-pointer bg-yellow-50 border-yellow-300"
                                :class="selectedMethod === 'pay_later' ? 'border-yellow-600 bg-yellow-100' : ''">
                                <input type="radio" name="payment_method" value="pay_later"
                                    x-model="selectedMethod" class="mt-1 text-yellow-600">
                                <div>
                                    <p class="font-semibold text-yellow-700">Pay Later</p>
                                    <p class="text-sm text-gray-600">
                                        Reserve now and pay within 3 days to keep your lot. Unpaid reservations will be automatically canceled.
                                    </p>
                                </div>
                            </label>

                            <!-- 🏦 Bank Transfer -->
                            <label class="flex items-start p-4 space-x-3 border rounded-md cursor-pointer bg-blue-50 border-blue-300"
                                :class="selectedMethod === 'bank_transfer' ? 'border-blue-600 bg-blue-100' : ''">
                                <input type="radio" name="payment_method" value="bank_transfer"
                                    x-model="selectedMethod" class="mt-1 text-blue-600">
                                <div>
                                    <p class="font-semibold text-blue-700">Bank Transfer</p>
                                    <p class="text-sm text-gray-600">
                                        Transfer directly to our bank account and upload your proof of payment below.
                                    </p>
                                </div>
                            </label>

                            <!-- 👇 Show upload field only if Bank Transfer is selected -->
                            <div x-show="selectedMethod === 'bank_transfer'" x-transition class="p-4 border border-blue-200 bg-blue-50 rounded-md">
                                <label class="block text-sm font-semibold text-[#1E4D2B] mb-2">
                                    Upload Proof of Payment (Image)
                                </label>
                                <input type="file" name="payment_proof" accept="image/*"
                                    class="block w-full text-sm text-gray-700 border rounded-md cursor-pointer focus:outline-none bg-white">
                                <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, JPEG, PNG, WEBP (max 5MB)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 Footer -->
                    <div class="flex items-center justify-between px-6 py-4 border-t bg-gray-50">
                        <button type="button" @click="step = 1"
                            class="text-[#1E4D2B] font-medium flex items-center space-x-2 hover:underline">
                            Back to Step 1
                        </button>

                        <button type="submit"
                            class="bg-[#1E4D2B] hover:bg-[#16381f] px-6 py-2 text-white transition-colors rounded-md">
                            Pay Now
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </template>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('modal', () => ({
            open: false,
            step: 1,
            paymentSuccess: false,
            fullName: '',
            contactNumber: '',
            email: '',
            telephoneNumber: '',
            termsAccepted: false,
            confirmationAccepted: false,
            paymentType: 'partial', // default to partial
            error: {
                fullName: '',
                contactNumber: '',
                email: '',
                terms: '',
                confirmation: ''
            },

            validateAndProceed() {
                this.error = {
                    fullName: '',
                    contactNumber: '',
                    email: '',
                    terms: '',
                    confirmation: ''
                };
                let valid = true;

                if (!this.fullName.trim()) {
                    this.error.fullName = 'Full name is required.';
                    valid = false;
                }
                if (!this.contactNumber.trim()) {
                    this.error.contactNumber = 'Contact number is required.';
                    valid = false;
                } else if (!/^09\d{9}$/.test(this.contactNumber)) {
                    this.error.contactNumber = 'Enter a valid Philippine number (09XXXXXXXXX).';
                    valid = false;
                }
                if (!this.email.trim()) {
                    this.error.email = 'Email is required.';
                    valid = false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email)) {
                    this.error.email = 'Enter a valid email address.';
                    valid = false;
                }
                if (!this.termsAccepted) {
                    this.error.terms = 'You must agree to the Terms & Conditions.';
                    valid = false;
                }
                if (!this.confirmationAccepted) {
                    this.error.confirmation = 'You must confirm that your details are correct.';
                    valid = false;
                }

                if (valid) this.step = 2;
            }
        }));
    });
</script>