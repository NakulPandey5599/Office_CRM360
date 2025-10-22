@component('mail::message')
# Offer Letter

Dear {{ $offer->candidate_name }},

We are pleased to offer you the position of **{{ $offer->designation }}** in the **{{ $offer->department }}** department at our **{{ $offer->location }}** office.

Your CTC will be **{{ $offer->ctc }}**, and your joining date is **{{ \Carbon\Carbon::parse($offer->joining_date)->format('d M, Y') }}**.

We look forward to having you on board.

Thanks,<br>
**HR Team, XYZ Corp**
@endcomponent
