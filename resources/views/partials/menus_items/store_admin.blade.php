<li>
    <a href="javascript: void(0);">
        <i class="uil uil-shop"></i>
        <span class = 'second'> Store </span>
        <span class="menu-arrow"></span>
    </a>

    <ul class="nav-second-level" aria-expanded="false">
        <li>
            <a href="{{ route('store.index') }}">Manage Store</a>
        </li>
        <li>
            <a href="{{ route('assistants.index') }}">Manage Store Assistant</a>
        </li>

    </ul>
</li>


<li>
    <a href="javascript: void(0);">
        <i data-feather="credit-card"></i>
        <span class='fourth'> Transactions </span>
        <span class="menu-arrow"></span>
    </a>

    <ul class="nav-second-level" aria-expanded="false">
        <li>
            <a href="{{ route('transaction.index') }}">Manage Transactions</a>
        </li>
        <li>
            <a href="{{ route('debtor.index') }}">Manage Debtors</a>
        </li>

    </ul>
</li>


<li>
    <a href="{{ route('customer.index') }}">
        <i class='uil uil-chat-bubble-user'></i>
        <span class="third"> Customers </span>
    </a>
</li>


<li>
    <a href="{{ route('broadcast.index') }}">
        <i data-feather="message-square"></i>
        <span class ='fifth'> Broadcast Message </span>
    </a>
</li>

<li>
    <a href="{{ route('complaint.index') }}">
        <i data-feather="book"></i>
        <span class ='sixth'> Complaint</span>
    </a>
</li>
