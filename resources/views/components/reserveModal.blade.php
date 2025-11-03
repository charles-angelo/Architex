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
                        <div class="mt-4 space-y-2 text-sm mb-6">
                            <label class="flex items-start space-x-2">
                                <input type="checkbox" class="mt-1" x-model="termsAccepted">
                                <span>I agree to the
                                    <a href="#" class="text-[#1E4D2B] underline">Terms & Conditions</a>
                                    and the
                                    <a href="#" class="text-[#1E4D2B] underline">Privacy Policy</a>.
                                </span>
                            </label>
                            <p x-show="error.terms" class="text-red-500 text-sm mt-1" x-text="error.terms"></p>

                            <label class="flex items-start space-x-2">
                                <input type="checkbox" class="mt-1" x-model="confirmationAccepted">
                                <span>
                                    I confirm that the details provided are true and correct, and I understand that this
                                    reservation is subject to approval.
                                </span>
                            </label>
                            <p x-show="error.confirmation" class="text-red-500 text-sm mt-1" x-text="error.confirmation"></p>
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
                    class="p-6 space-y-6 overflow-y-auto max-h-[80vh]">
                    @csrf
                    <input type="hidden" name="lot_id" :value="activeLot?.id ?? ''">
                    <input type="hidden" name="full_name" x-model="fullName">
                    <input type="hidden" name="email" x-model="email">
                    <input type="hidden" name="contact_number" x-model="contactNumber">
                    <input type="hidden" name="telephone_number" x-model="telephoneNumber">
                    <input type="hidden" name="total" :value="activeLot?.price ?? 0">

                    <!-- 👇 New hidden field for STATUS -->
                    <input
                        type="hidden"
                        name="status"
                        :value="paymentType === 'full' ? 'paid' : 'partial'">

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
                        <div class="space-y-4">
                            <label class="flex items-start p-4 space-x-3 border rounded-md cursor-pointer">
                                <input type="radio" name="payment_method" class="mt-1 text-[#1E4D2B]" value="gcash" checked>
                                <div>
                                    <p class="font-semibold text-[#1E4D2B]">GCash</p>
                                    <p class="text-sm text-gray-600">Pay easily using your GCash account.</p>
                                </div>
                            </label>

                            <label class="flex items-start p-4 space-x-3 border rounded-md cursor-pointer">
                                <input type="radio" name="payment_method" class="mt-1 text-[#1E4D2B]" value="paymaya">
                                <div>
                                    <p class="font-semibold text-[#1E4D2B]">PayMaya</p>
                                    <p class="text-sm text-gray-600">Use your PayMaya account to complete payment.</p>
                                </div>
                            </label>

                            <!-- 🟣 NEW: Pay Later option -->
                            <label class="flex items-start p-4 space-x-3 border rounded-md cursor-pointer bg-yellow-50 border-yellow-300">
                                <input type="radio" name="payment_method" class="mt-1 text-yellow-600" value="pay_later">
                                <div>
                                    <p class="font-semibold text-yellow-700">Pay Later</p>
                                    <p class="text-sm text-gray-600">
                                        Reserve now and pay within 3 days to keep your lot. Unpaid reservations will be automatically canceled.
                                    </p>
                                </div>
                            </label>
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