<?php
session_start();

if (!isset($_SESSION['login_id'])) {
    // Redirect to login page
    header("Location: login.php?redirect=buy.php&plan=" . $_GET['plan']);
    exit();
}

$plan = htmlspecialchars($_GET['plan']);

$totalCharge = 0;

switch ($plan) {
    case 'standard_monthly':
        $planname = '1-Month';
        $singleCharge = 12.95;
        $totalCharge = 1295; // $12.95 per month
        $duration = 1;
        $expire_date = date('Y-m-d', strtotime('+1 months'));
        break;
    case 'standard_halfyear':
        $planname = '6-Month';
        $expire_date = date('Y-m-d', strtotime('+6 months'));
        $singleCharge = 9.99;
        $duration = 6;
        $totalCharge = 5994; // $9.99 per month * 6 months
        break;
    case 'premium_yearly':
        $planname = '12-Month';
        $expire_date = date('Y-m-d', strtotime('+1 year'));
        $singleCharge = 6.67;
        $duration = 12;
        $totalCharge = 8004; // $6.67 per month * 12 months
        break;
    default:
        header("Location: login.php");
        echo json_encode(['error' => 'Invalid plan selected']);
        exit();
}

$dedicatedIpChargePerMonth = 419;
$dedicatedIpTotalCharge = $dedicatedIpChargePerMonth * $duration;

include_once 'backend/controller/config.php';

if (isset($_SESSION['login_id'])) {
    $user = $crud->select('users', '*', null, "`user_id`=?", array($_SESSION['login_id'])); // get user details
    $anonymousEmail = $crud->anonymizeEmail($user['email']);
    $_SESSION['user_email'] = $anonymousEmail;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TunnelVPN</title>
    <link rel="stylesheet" href="dist/iofrm-style.css">
    <link rel="stylesheet" href="dist/iofrm-theme.css">
    <link rel="stylesheet" href="dist/payment.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

</head>

<body class="bg-light-grey">

    <?php include('include/guest_navbar.php'); ?>

    <div class="main-container pb-4 mt-1">
        <div class="container">
            <div class="row row-gap-4">
                <div class="secure-checkout-container">
                    <div class="secure-checkout-icon d-flex align-items-center">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="#001D2F" fill-rule="evenodd" d="M19.2928932,6.29289322 C19.6834175,5.90236893 20.3165825,5.90236893 20.7071068,6.29289322 C21.0675907,6.65337718 21.0953203,7.22060824 20.7902954,7.61289944 L20.7071068,7.70710678 L9.70710678,18.7071068 C9.34662282,19.0675907 8.77939176,19.0953203 8.38710056,18.7902954 L8.29289322,18.7071068 L3.29289322,13.7071068 C2.90236893,13.3165825 2.90236893,12.6834175 3.29289322,12.2928932 C3.65337718,11.9324093 4.22060824,11.9046797 4.61289944,12.2097046 L4.70710678,12.2928932 L9,16.585 L19.2928932,6.29289322 Z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="secure-checkout-text-wrapper">
                        <span class="secure-checkout-title">Secure checkout</span>
                        <span class="secure-checkout-content">Your payment information is fully protected.</span>
                    </div>
                </div>
                <div class="col-lg-7">
                    <form id="payment-form">
                        <div class="part-1">
                            <h4 class="mb-3">1. Billing Details</h4>
                            <div class="card">
                                <div class="card-body pay-box">
                                    <div class="form-group row">
                                        <div class="col-12 col-md-6">
                                            <input type="text" id="name" name="name" required placeholder="Name">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="email" id="email" name="email" required placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="Address" id="address" name="Address" required placeholder="Address">
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12 col-md-6">
                                            <input type="City" id="city" name="City" required placeholder="City">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="State" id="state" name="State" required placeholder="State">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <select type="text" id="country" name="country" required placeholder="Country">
                                            <option selected disabled>Select Country</option>
                                            <?php
                                            include_once 'include/countries.php';
                                            foreach ($countries as $code => $name) {
                                                echo "<option value=\"$code\">$name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="part-2 py-3 my-3">
                            <h4 class="mb-3">2. Extra services (optional)</h4>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dedicated_ip" id="dedicated_ip" onclick="toggleDedicatedIpFields()">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Add Dedicated IP ($4.19/month)
                                        </label>
                                    </div>
                                    <div id="dedicated-ip-fields" style="display:none;">
                                        <label for="dedicated_ip_city">City:</label>
                                        <input type="text" id="dedicated_ip_city" name="city" class="form-control contact-form">
                                        <label for="dedicated_ip_country">Country:</label>
                                        <input type="text" id="dedicated_ip_country" name="country" class="form-control contact-form">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="part-3">
                            <h4 class="mb-3">3. Enter Your Payment Details</h4>
                            <div class="card">
                                <div class="card-body pay-box">
                                    <style>
                                        #card-element {
                                            background-color: #dee2e6;
                                            padding: 12px;
                                            border-radius: 4px;
                                            border: 1px solid #ccc;
                                        }
                                    </style>
                                    <div class="form-group mb-3">
                                        <label for="form-label">Credit or debit card</label>
                                        <div id="card-element" class="StripeElement StripeElement--empty"></div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn-primary">Submit</button>
                                    </div>
                                    <!-- small text that say to wait after clicking on submit -->
                                    <small>
                                        After Clicking on Submit, Please Wait to Process
                                    </small>
                                    <div id="card-errors" class="mt-3 alert alert-danger" role="alert" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5 ">
                    <h4>Order Summary</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="summary-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <p>
                                        <?php echo $planname; ?> Plan
                                    </p>
                                    <p>$
                                        <?php echo $singleCharge; ?>
                                    </p>
                                </div>
                                <div class="align-items-center justify-content-between" id="price_ip" style="display: none;">
                                    <p>Dedicated IP</p>
                                    <p>$
                                        <?php echo number_format($dedicatedIpTotalCharge / 100, 2) ?>
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between b-top">
                                    <p><strong>Total Order</strong></p>
                                    <p class="price">$<span id="total-price">
                                            <?php echo number_format($totalCharge / 100, 2); ?>
                                        </span></p>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <p><strong>Account:</strong>
                                    <?php echo $_SESSION['user_email'] ?? 'Not Logged In'; ?>
                                </p>
                                <p><strong>Expire:</strong>
                                    <?php echo $expire_date; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function() {
            var totalCharge = <?php echo $totalCharge; ?>;
            var dedicatedIpCharge = <?php echo $dedicatedIpTotalCharge; ?>;

            $('#dedicated_ip').change(function() {
                if ($(this).is(':checked')) {
                    totalCharge += dedicatedIpCharge;
                    $('#dedicated_ip_city').attr('required', true);
                    $('#dedicated_ip_country').attr('required', true);
                } else {
                    totalCharge -= dedicatedIpCharge;
                    $('#dedicated_ip_city').removeAttr('required');
                    $('#dedicated_ip_country').removeAttr('required');
                }
                $('#total-price').text((totalCharge / 100).toFixed(2));
            });
        });

        function toggleDedicatedIpFields() {
            var checkBox = document.getElementById('dedicated_ip');
            var dedicatedIpFields = document.getElementById('dedicated-ip-fields');
            var dedicatedIpPrice = document.getElementById('price_ip');
            dedicatedIpFields.style.display = checkBox.checked ? 'block' : 'none';
            dedicatedIpPrice.style.display = checkBox.checked ? 'flex' : 'none';
        }
    </script>

    <script>
        const stripe = Stripe('pk_test_51NRfsYIxw1u7K45rHsOVnnLrGcYlYMmnehPJDwcsUCRa8nFqy1fPLiU8yltxIwRvW2AH8d5IwfLFVg8StGwkze8S006Timd8p6'); // Replace with your Stripe public key

        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        const elements = stripe.elements();
        var card = elements.create('card', {
            style: style
        });
        card.mount('#card-element');

        $('#payment-form').submit(async function(event) {
            event.preventDefault();

            const name = $('#name').val();
            const email = $('#email').val();
            const address = $('#address').val();
            const city = $('#city').val();
            const country = $('#country').val();
            const state = $('#state').val();

            var isValid = true;
            var errorMessage = '';

            if ($('#dedicated_ip').is(':checked')) {
                if (!$('#dedicated_ip_city').val()) {
                    isValid = false;
                    errorMessage += 'City is required for dedicated IP.\n';
                }
                if (!$('#dedicated_ip_country').val()) {
                    isValid = false;
                    errorMessage += 'Country is required for dedicated IP.\n';
                }
            }

            if (!isValid) {
                alert(errorMessage);
                event.preventDefault();
                return
            }

            // Dedicated IP fields
            const dedicatedIp = $('#dedicated_ip').is(':checked') ? true : false;
            const dedicatedIpCity = $('#dedicated_ip_city').val();
            const dedicatedIpCountry = $('#dedicated_ip_country').val();


            try {
                const response = await fetch('create_payment_intent.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        plan: '<?php echo $plan; ?>',
                        name,
                        email,
                        address,
                        dedicatedIp,
                        dedicatedIpCity,
                        dedicatedIpCountry
                    })
                });
                const data = await response.json();

                if (data.error) {
                    if (data.error === 'not_logged_in') {
                        $('#card-errors').show().text('You must be logged in to proceed with the payment. Redirecting You To Login');
                        setTimeout(function() {
                            window.location.href = 'buy.php?plan=' + '<?php echo $plan; ?>';
                        }, 3000);
                    } else {
                        $('#card-errors').show().text(data.error);
                    }
                    return;
                }

                const {
                    paymentIntentClientSecret,
                    error: createError
                } = data;

                if (createError) {
                    $('#card-errors').show().text(createError);
                    return;
                }

                const {
                    error,
                    paymentIntent
                } = await stripe.confirmCardPayment(paymentIntentClientSecret, {
                    payment_method: {
                        card: card,
                        billing_details: {
                            name: name,
                            email: email,
                            address: {
                                line1: address,
                                state: state,
                                country: country,
                                city: city,
                            },
                        },
                    }
                });

                if (error) {
                    // Show error to your customer
                    $('#card-errors').show().text(error.message);
                } else if (paymentIntent.status === 'succeeded') {
                    // Set session variable to indicate successful payment
                    $.post('set_payment_success.php', {
                        plan: '<?php echo urlencode($plan); ?>',
                        transaction_id: paymentIntent.id,
                        receipt_email: email
                    }, function() {
                        // Redirect to success page
                        window.location.href = 'success.php';
                    });
                }

            } catch (err) {
                console.error('Error:', err);
                $('#card-errors').show().text('An error occurred while processing your payment. Please try again.');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>