public function countVisitsForToday($registrationNumber)
{
    Log::info('Received Registration Number: ' . $registrationNumber);

    // Fetch the child ID using the registration number
    $child = DB::table('children')
        ->where('registration_number', $registrationNumber)
        ->select('id')
        ->first();

    if (!$child) {
        return response()->json([
            'message' => 'Child not found',
            'count' => 0,
        ], 404);
    }

    // Get today's date
    $today = Carbon::now()->toDateString();

    // Fetch visits for today, including visit type, prices, and copay amount
    $visits = DB::table('visits')
        ->join('visit_type', 'visits.visit_type', '=', 'visit_type.id')
        ->where('visits.child_id', $child->id)
        ->whereDate('visits.visit_date', $today)
        ->select(
            'visit_type.visit_type as visit_type_name',
            'visit_type.sponsored_price',
            'visit_type.normal_price',
            'visits.payment_mode_id',
            'visits.copay_amount'
        )
        ->get();

    if ($visits->isEmpty()) {
        return response()->json([
            'message' => 'No visit for today',
        ], 200);
    }

    // Initialize invoice details
    $invoiceDetails = [];

    // Populate invoice details and calculate the total amount
    foreach ($visits as $visit) {
        $price = ($visit->payment_mode_id == 3) 
            ? $visit->sponsored_price 
            : $visit->normal_price;

        $invoiceDetails[$visit->visit_type_name] = [
            'price' => $price,
            'copay_amount' => !is_null($visit->copay_amount) ? $visit->copay_amount : 0
        ];
    }

    // Calculate the total amount (excluding copay from the calculation)
    $totalAmount = array_sum(array_column($invoiceDetails, 'price'));

    // Check if an invoice already exists for today
    $existingInvoice = DB::table('invoices')
        ->where('child_id', $child->id)
        ->whereDate('invoice_date', $today)
        ->first();

    if ($existingInvoice) {
        // Update the existing invoice
        DB::table('invoices')
            ->where('id', $existingInvoice->id)
            ->update([
                'invoice_details' => json_encode($invoiceDetails),
                'total_amount' => $totalAmount,
            ]);

        return response()->json([
            'message' => 'Invoice updated successfully',
            'invoice_id' => $existingInvoice->id,
            'total_amount' => $totalAmount,
            'invoice_details' => $invoiceDetails,
        ]);
    } else {
        // Insert a new invoice with `invoice_status = false`
        $invoiceId = DB::table('invoices')->insertGetId([
            'child_id' => $child->id,
            'invoice_details' => json_encode($invoiceDetails),
            'total_amount' => $totalAmount,
            'invoice_date' => $today,
            'invoice_status' => false, // Always set to false (or 0)
        ]);

        return response()->json([
            'message' => 'Invoice generated successfully',
            'invoice_id' => $invoiceId,
            'total_amount' => $totalAmount,
            'invoice_details' => $invoiceDetails,
        ]);
    }
}
