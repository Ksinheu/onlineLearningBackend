
<div wire:poll.5s="getNewPurchase">
    @if (!empty($newPayments))
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>អតិថិជន</th>
                    <th>ទិញវគ្គសិក្សា</th>
                    <th>តម្លែ</th>
                    <th>ស្ថានភាព</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($newPayments as $payment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ Str::limit($payment->customer->username, 10) }}</td>
                        <td>{{ Str::limit($payment->course->course_name, 20) }}</td>
                        <td>{{ number_format($payment->course->price) }} $</td>
                        <td><span class="text-success">{{ $payment->payment_status }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-success">No new payments at the moment.</div>
    @endif

    @if ($showPopup)
         <div class="web-popup web-popup-active">
            <div class="pp-box pp-success">
                <div class="pp-head df-s">
                    <div class="text left-05 df-l">
                        <div class="icon icon-ra icon-sm">
                            <svg class="error" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"><path d="m14 16.16-3.96-3.96M13.96 12.24 10 16.2M10 6h4c2 0 2-1 2-2 0-2-1-2-2-2h-4C9 2 8 2 8 4s1 2 2 2Z" stroke="#FF8A65" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path d="M16 4.02c3.33.18 5 1.41 5 5.98v6c0 4-1 6-6 6H9c-5 0-6-2-6-6v-6c0-4.56 1.67-5.8 5-5.98" stroke="#FF8A65" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            <svg class="success" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"><path d="M12 22c5.5 0 10-4.5 10-10S17.5 2 12 2 2 6.5 2 12s4.5 10 10 10Z" stroke="#FF8A65" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="m7.75 12 2.83 2.83 5.67-5.66" stroke="#FF8A65" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            <svg class="warning" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"><path d="M12 7.75V13M21.08 8.58v6.84c0 1.12-.6 2.16-1.57 2.73l-5.94 3.43c-.97.56-2.17.56-3.15 0l-5.94-3.43a3.15 3.15 0 0 1-1.57-2.73V8.58c0-1.12.6-2.16 1.57-2.73l5.94-3.43c.97-.56 2.17-.56 3.15 0l5.94 3.43c.97.57 1.57 1.6 1.57 2.73Z" stroke="#FF8A65" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 16.2v.1" stroke="#FF8A65" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            <svg class="infor" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"><path d="M12 22c5.5 0 10-4.5 10-10S17.5 2 12 2 2 6.5 2 12s4.5 10 10 10ZM12 8v5" stroke="#FF8A65" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.995 16h.009" stroke="#FF8A65" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                        <p></p>
                    </div>
                    <div class="icon icon-ra icon-sm right-05" wire:click="closePopup">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                             viewBox="0 0 24 24" fill="none">
                            <path d="M6 12h12M12 18V6"
                                  stroke="#FF8A65" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <blockquote>
                    <div class="db-c">
                        @foreach($newPayments as $item)
                            <p>
                                <b><span style="font-size: 1.4rem;margin-right: 0.1rem;">🔥</span>មានការទិញវគ្គសិក្សាថ្មី</b><br>
                                ឈ្មោះអ្នកទិញ៖ {{$item->customer->username}}<br>
                                វគ្គសិក្សា៖ {{$item->course->course_name}}<br>
                                តម្លៃវគ្គសិក្សា៖ {{$item->course->price}}$<br>
                            </p>
                        @endforeach
                        <p>សូមពិនិត្យឱ្យបានលឿន ដើម្បីផ្ដល់សេវាកម្មល្អដល់អតិថិជន🙏🙏🙏</p>
                    </div>
                </blockquote>
                <div class="pp-foot">
                    <div class="ppf-box df-s left-05 right-05">
                        <p></p>
                        <div class="df-l">
                            <a wire:click="closePopup" onclick="removeFormPopup(this)" class="btn curs-p btn-accancel">
                                បោះបង់
                            </a>
                            <a  target="_blank" href="{{route('payment.index')}}" class="btn btn-ok">
                                ពិនិត្យ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pp-bg"></div>
        </div>
    @endif



</div>
