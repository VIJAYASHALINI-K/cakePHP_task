</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($users) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('fname');
            echo $this->Form->control('lname');
            echo $this->Form->control('email');
            echo $this->Form->control('password');
            echo $this->Form->control('address_line_1');
            echo $this->Form->control('address_line_2');
            echo $this->Form->control('pincode');
            echo $this->Form->control('phone_number');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
