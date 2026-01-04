<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Premium Calculator</title>
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Insurance Premium Calculator</h1>
        <form id="premiumForm" class="row g-3">
            {{-- <div class="col-md-6">
                <label for="insuredAmount" class="form-label">Insured Amount<span class="text-danger">*</span>:</label>
                <input type="number" class="form-control" id="insuredAmount" name="base_rate" value="" required>
            </div> --}}

            <div class="col-md-3">
                <label for="" class="form-label">Policy<span class="text-danger">*</span></label>
                <select class="form-select" name="policy_id" id="policy_id">
                    <option value="">Select one</option>
                    @foreach ($policies as $id => $policy)
                        <option value="{{ $id }}">{{ $policy }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="" class="form-label">Group<span class="text-danger">*</span></label>
                <select class="form-select" name="group_id" id="group_id">
                    <option value="">Select one</option>
                    @foreach ($groups as $id => $group)
                        <option value="{{ $id }}">{{ $group }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="insuredAmount" id="insuredAmount">
            </div>
            <div class="col-md-6">
                <label for="numDependents" class="form-label">Number of Dependents<span class="text-danger">*</span>
                    (including self):</label>
                <input type="number" class="form-control" id="numDependents" name="dependent_factor"required>
            </div>
            <div class="col-md-6">
                <label for="dob" class="form-label">Date of Birth<span class="text-danger">*</span>:</label>
                <input type="date" class="form-control" id="dob" name="age_factor" required>
            </div>
            <div class="col-md-6">
                <label for="insurancePeriod" class="form-label">Insurance Period<span class="text-danger">*</span> (in
                    years):</label>
                <input type="number" class="form-control" id="insurancePeriod" name="period_factor" required>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary" id="calculatePremium">Calculate Premium</button>
            </div>
        </form>
        <h2 class="text-center mt-4">Insured Amount: Rs.<span id="insuredAmountResult">0.00</span></h2>
        <h2 class="text-center mt-4">Calculated Premium: Rs.<span id="premiumResult">0.00</span></h2>
    </div>

    <script>
        function calculateAge(dob) {
            var birthDate = new Date(dob);
            var currentDate = new Date();
            var age = currentDate.getFullYear() - birthDate.getFullYear();
            var monthDiff = currentDate.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && currentDate.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }

        $(document).ready(function() {
            $('#calculatePremium').click(function() {
                var insuredAmount = parseFloat($('#insuredAmount').val());
                var numDependents = parseFloat($('#numDependents').val());
                var dob = $('#dob').val();
                var insurancePeriod = parseFloat($('#insurancePeriod').val());
                var policy = parseFloat($('#policy_id').val());
                var group = parseFloat($('#group_id').val());

                $(".is-invalid").removeClass("is-invalid");
                var isValid = true;

                if (isNaN(policy) || policy <= 0) {
                    $("#policy_id").addClass("is-invalid");
                    isValid = false;
                }
                if (isNaN(group) || group <= 0) {
                    $("#group_id").addClass("is-invalid");
                    isValid = false;
                }

                if (isNaN(insuredAmount) || insuredAmount <= 0) {
                    $("#insuredAmount").addClass("is-invalid");
                    isValid = false;
                }
                if (isNaN(numDependents) || numDependents <= 0) {
                    $("#numDependents").addClass("is-invalid");
                    isValid = false;
                }
                if (!dob) {
                    $("#dob").addClass("is-invalid");
                    isValid = false;
                }
                if (isNaN(insurancePeriod) || insurancePeriod <= 0) {
                    $("#insurancePeriod").addClass("is-invalid");
                    isValid = false;
                }
                if (isValid) {
                    var insuredAmount = $("#insuredAmount").val();
                    var baseRatePerThousand = parseFloat({{ $premium->base_rate }})
                    var ageFactorBase = parseFloat({{ $premium->age_factor }});
                    var dependentFactor = parseFloat({{ $premium->dependent_factor }});
                    var periodFactorBase = parseFloat({{ $premium->period_factor }});
                    var age = calculateAge(dob);
                    var ageFactor = ageFactorBase + (age * 0.02);
                    var periodFactor = periodFactorBase + (insurancePeriod * 0.05);
                    var totalDependentFactor = Math.pow(dependentFactor, numDependents);

                    // Calculate premium
                    var premium = (insuredAmount / 1000) * baseRatePerThousand * ageFactor *
                        totalDependentFactor * periodFactor;

                    // Display the calculated premium
                    $("#insuredAmountResult").text(insuredAmount);
                    $('#premiumResult').text(premium.toFixed(2));
                }

            });

            $(document).on("change", "#policy_id", function() {
                let policy_id = $(this).val();
                let dataUrl = "/get-group-data/" + policy_id;
                $.ajax({
                    type: "get",
                    url: dataUrl,
                    success: function(res) {
                        console.log(res);
                        let group = res.response;
                        $("#group_id").empty();
                        // $("#group_id").html('<option value="">Select one</option>');

                        $.each(group, function(index, data) {
                            $("#group_id").append(
                                `<option value='${data.id}'>${data.name}</option>`
                            );
                        });
                        $("#group_id").trigger("change");
                    }
                });
            });

            $(document).on("change", "#group_id", function() {
                let group_id = $(this).val();
                let dataUrl = "/get-insured-amount-data/" + group_id;

                $.ajax({
                    type: "get",
                    url: dataUrl,
                    success: function(res) {
                        console.log(res);
                        let group = res.response;

                        $("#policy_id").empty();
                        // $("#policy_id").append('<option value="">Select one</option>');

                        if (Array.isArray(group)) {
                            $.each(group, function(index, data) {
                                $("#policy_id").append(
                                    `<option value='${data.id}'>${data.policy_no}</option>`
                                );
                            });
                        } else if (group && group.policy) {
                            $("#policy_id").append(
                                `<option value='${group.policy.id}'>${group.policy.policy_no}</option>`
                            );
                            $("#insuredAmount").val(group.insurance_amount);
                        } else {
                            $("#policy_id").append(
                                '<option value="">No policies available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: ", error);
                    }
                });
            });

        });
    </script>
</body>

</html>
