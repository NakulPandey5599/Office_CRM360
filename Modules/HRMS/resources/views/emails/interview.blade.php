@component('mail::message')
# Hello {{ $candidate->full_name }},

We are pleased to inform you that your interview has been scheduled.

**Interview Details:**
- **Mode:** {{ $candidate->interview_mode }}
- **Date:** {{ $candidate->interview_date }}
- **Time:** {{ $candidate->interview_time }}

Please be prepared and ensure a stable internet connection (if online).

Thanks,  
**HR Team**  
@endcomponent
