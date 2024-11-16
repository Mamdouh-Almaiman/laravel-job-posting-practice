<?php
/*

<h1><?php echo $heading; ?>
?>
?>
?>
?>
?>
?></h1>
<?php foreach($listings as $listing): ?>
<h2><?php echo $listing['title']; ?></h2>
<p><?php echo $listing['description']; ?> </p>
<?php endforeach; ?>

// blade.php help us to make the code way cleaner since php language is kinda ugly
// for exp the code above using php file and down is the blade.php
*/
?>


<x-layout>
    @include('partials._hero')
    @include('partials._search')
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

        @if (count($listings) == 0)
            <p>No listings found</P>
        @endif

        @foreach ($listings as $listing)
            {{-- this is how to access listing-card components and here we are passing the listing variable, so baicelly the code in the components is here and we are passing the value of the listing of the the foreache to minimalize the code and make it cleaner --}}
            <x-listing-card :listing="$listing" />
            {{-- if we want are passing a variable then we must add : --}}
        @endforeach

    </div>

    <div class="mt-6 p-4">
        {{$listings-> links()}}
    </div>
</x-layout>
