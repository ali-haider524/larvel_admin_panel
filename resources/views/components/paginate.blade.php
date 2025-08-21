@if($paginator->hasPages())
<nav aria-label="Page navigation example">
    <ul class="pagination pagination-info justify-content-center">

        <?php

        $interval = isset($interval) ? abs(intval($interval)) : 3;
        $from = $paginator->currentPage() - $interval;
        if ($from < 1) {
            $from = 1;
        }

        $to = $paginator->currentPage() + $interval;
        if ($to > $paginator->lastPage()) {
            $to = $paginator->lastPage();
        }
        ?>

        <!-- first/previous -->
        @if($paginator->currentPage() > 1)

        <li class="page-item">
            <a href="{{ $paginator->url(1) }}" class="page-link">
                <span aria-hidden="true">«</span>
            </a>
        </li>

        <li class="page-item">
            <a href="{{ $paginator->url($paginator->currentPage() - 1) }}" class="page-link" aria-label="Previous">
                <span aria-hidden="true"><i class="ni ni-bold-left" aria-hidden="true"></i></span>
            </a>
        </li>
        @endif



        @for($i = $from; $i <= $to; $i++) <?php
                                            $isCurrentPage = $paginator->currentPage() == $i;
                                            ?> <li class="page-item {{ $isCurrentPage ? 'active' : '' }}">
            <a class="page-link" href="{{ !$isCurrentPage ? $paginator->url($i) : '#' }}">
                {{ $i }}
            </a>
            </li>
            @endfor

            <!-- next/last -->
            @if($paginator->currentPage() < $paginator->lastPage())
                <li class="page-item">
                    <a href="{{ $paginator->url($paginator->currentPage() + 1) }}" class="page-link" aria-label="Next">
                        <span aria-hidden="true"><i class="ni ni-bold-right" aria-hidden="true"></i></span>
                    </a>
                </li>

                <li class="page-item">
                    <a href="{{ $paginator->url($paginator->lastpage()) }}" class="page-link" aria-label="Next">
                        <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                    </a>
                </li>
                @endif
    </ul>
</nav>
@endif