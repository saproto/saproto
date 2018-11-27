<form method="post"
      action="{{ ($new ? route("achievement::add") : route("achievement::update", ['id' => $achievement->id])) }}">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            @yield('page-title')
            @if(!$new)
                <span class="badge badge-info float-right">
                    Obtained by {{ count($achievement->currentOwners(true)) }} members
                </span>
            @endif
        </div>

        <div class="card-body">

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Be Awesome"
                       value="{{ $achievement->name or '' }}" required>
            </div>

            <div class="form-group">
                <label for="desc">Description:</label>
                <input type="text" class="form-control" id="desc" name="desc"
                       placeholder="Become member of Proto"
                       value="{{ $achievement->desc or '' }}" required>
            </div>

            <div class="form-group">
                <label for="tier">Tier:</label>
                <select class="form-control {{ $achievement->tier or '' }}" name="tier">
                    <option value="COMMON"
                            {{ (!$new && $achievement->tier == "COMMON" ? 'selected' : '') }}>
                        Common
                    </option>
                    <option value="UNCOMMON"
                            {{ (!$new && $achievement->tier == "UNCOMMON" ? 'selected' : '') }}>
                        Uncommon
                    </option>
                    <option value="RARE"
                            {{ (!$new && $achievement->tier == "RARE" ? 'selected' : '') }}>Rare
                    </option>
                    <option value="EPIC"
                            {{ (!$new && $achievement->tier == "EPIC" ? 'selected' : '') }}>Epic
                    </option>
                    <option value="LEGENDARY"
                            {{ (!$new && $achievement->tier == "LEGENDARY" ? 'selected' : '') }}>
                        Legendary
                    </option>
                </select>
            </div>

            <div class="form-group">
                <input type="hidden" name="excludeFromAllAchievements" value="0">
                <input type="checkbox" id="excludeFromAllAchievements" name="excludeFromAllAchievements"
                       value="1" {{ (!$new && $achievement->excludeFromAllAchievements ? 'checked' : '') }}>
                <label for="isPrize">Exclude from 'all achievements' achievement</label>
            </div>

        </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-success float-right">Submit</button>

            <a href="{{ route("achievement::list") }}" class="btn btn-default">Cancel</a>

        </div>

    </div>

</form>