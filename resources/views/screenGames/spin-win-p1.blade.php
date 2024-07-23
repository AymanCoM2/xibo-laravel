<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('spin/p1.css') }}" />
</head>

<body>
    <div class="modal-container" id="mdco">
        <div class="modal">
            <div class="form-group">
                <label for="invoice">Invoice Number:</label>
                <div class="input-container">
                    <input type="text" name="invoice" id="invoice" class="text-input" />
                    <div class="invalid-feedback" id="invalid_feedback" style="color: red;">

                    </div>
                    <button type="button" id="deleteButton">X</button>
                    <button type="button" id="checkButton">Check</button>
                </div>
            </div>
            <div class="number-grid">
                <button type="button" class="number-button">1</button>
                <button type="button" class="number-button">2</button>
                <button type="button" class="number-button">3</button>
                <button type="button" class="number-button">4</button>
                <button type="button" class="number-button">5</button>
                <button type="button" class="number-button">6</button>
                <button type="button" class="number-button">7</button>
                <button type="button" class="number-button">8</button>
                <button type="button" class="number-button">9</button>
                <button type="button" class="number-button">0</button>
            </div>
        </div>
    </div>

    <form action="{{ route('spin-win-page-p2') }}" id="next_page_spin" method="post">
        {{-- Hidden Form To Next Action,Submitted If all is Good --}}
        @csrf
        <input type="hidden" name="invoiceNumber" id="theSentInvoice">
    </form>

    <script>
        const baseURL = "{{ url('/') }}";
        const checkButton = document.getElementById("checkButton");

        checkButton.addEventListener("click", function() {
            const invoiceInput = document.getElementById("invoice");
            const feedBack = document.getElementById("invalid_feedback");
            const nextPageForm = document.getElementById("next_page_spin");
            const invoiceValue = invoiceInput.value;
            fetch(`${baseURL}/check-invoice/${invoiceValue}`)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    // Check Here Vlaid of Not to Submit form 
                    console.log("API Response:", data);
                    if (data.valid) {
                        // GET TO NEXT Form 
                        // alert('VALID');
                        document.getElementById("theSentInvoice").value = invoiceValue;
                        nextPageForm.submit();
                    } else {
                        invoiceInput.style.border = "2px solid red";
                        feedBack.innerText = data.message;
                    }
                })
                .catch((error) => {
                    alert(error.message);
                    console.error("Error:", error.message);
                });
        });

        const invoiceInput = document.getElementById("invoice");
        const numberButtons = document.querySelectorAll(".number-button");
        const deleteButton = document.getElementById("deleteButton");

        numberButtons.forEach((button) => {
            button.addEventListener("click", function() {
                const number = this.textContent;
                invoiceInput.value += number;
            });
        });
        deleteButton.addEventListener("click", function() {
            invoiceInput.value = invoiceInput.value.slice(0, -1); // Remove last character
        });
    </script>
</body>

</html>


{{-- 
    Prevent From From Checking and then Check Invoice ,
    if Invalid ,Prevent and show Error 
    if Valid , Submit Form To the Spinning Wheel + Prizes For this user 
--}}
