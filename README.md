# RudWEb 2009-2011

My PHP framework RudWEb from the day it moved to Subversion (2009-02) to the end of the 5.0 rewrite (2011-12): versions
1 to 4 with their engine, modules, setup utility and apps, then 5.0, started again from scratch. A historical archive,
kept read-only: PHP 5 code with `mysql_*` calls, not safe to deploy.

## Its place in the line

RudWEb → WEb is my PHP framework line, one archive per era:

1. [rudweb-2007-2009](https://github.com/webservco-legacy/rudweb-2007-2009): the first engine and RudWEb 0.1 to 0.8;
2. **rudweb-2009-2011** (this one): RudWEb 1 to 4 in Subversion, then 5.0, the rewrite from scratch;
   [rudwi](https://github.com/webservco-legacy/rudwi), the web desktop, and
   [rudweb-extras](https://github.com/webservco-legacy/rudweb-extras), the tutorials, skins and logos, belong to it;
3. [web-2012-2017](https://github.com/webservco-legacy/web-2012-2017): WEb 5 to 7;
4. [web7](https://github.com/webservco-legacy/web7): WEb7 as a git archive;
5. the framework in git since 2017: [framework-v9](https://github.com/webservco-v09/framework-v9), then
   [framework](https://github.com/webservco-v13/framework) (v10 to v13) and the WebServCo components.

## History

The Subversion tags are not kept as git tags; each was a copy of a commit on a branch, and the table names that commit.

| Date | Commit | |
|---|---|---|
| 2009-02-10 | 805f3af | RudWEb in Subversion: the first revision (branch `trunk-2009`) |
| 2009-06-23 | 64deaee | tag 0.0.0, "the first ever version" (the trunk's code as of this commit), then the branch `rudweb-reloaded` |
| 2009-09-06 | badcab4 | tag 0.1.0: `rudweb-reloaded` stops |
| 2009-09-06 | 2b58d00 | trunk emptied and started again from scratch (branch `main`) |
| 2009-10-03 | 698f26f | the two tags of 2009 renamed to 1.0.0 and 2.0.0 |
| 2010-01-27 | 0b2dae7 | the 2008 engine (RudWEb 0.8) imported as branch `1.0`, tagged 1.0.0 ("original v1!") |
| 2010-02-06 | fb69776 | tag 3.0.0 (of the trunk of 2010-01-31) and branch `3.0`, with the RudWI web desktop as an app |
| 2010-08-14 | 65465dc | tag 4.0.0 (of the trunk of 2010-06-10), "before start work on 5.0"; branch `4.0` follows |
| 2010-08-14 | db37183 | branch `5.0`, the rewrite, created empty |
| 2010-09-19 | a8deff7 | the first code of 5.0 |
| 2011-04-07 | 5c51c62 | the last commit on `4.0` |
| 2011-12-01 | 6a2d912 | the last commit of RudWEb (`5.0`) |

In 2012-03 the code of 5.0 went on as WEb 5 in a new repository; that history is in web-2012-2017.

## What is in it

- `trunk-2009`: the trunk from the first revision to 2009-09 (`rudweb/`, `rwlib/`, `htdocs/`, `work/`);
- `rudweb-reloaded`, `2.0`: the branches that grew from it in 2009;
- `main`: the trunk from its restart of 2009-09 to 2010-08 (`engine/`, `apps/`, `docs/tutorials/`, `work/`);
- `1.0`: the 2008 engine, RudWEb 0.8 (`kit/`, `setup/`, `test/`), imported in 2010;
- `3.0`, `4.0`: the versions 3 and 4, with the RudWI and test apps (`3.0`) and the RudTools app (`4.0`);
- `5.0`: the rewrite, 2010-08 to 2011-12 (`src/RudWEb/`, a sandbox app, tutorials, tests in `extra/`);
- `working-copy-1.0-2010-06`, `working-copy-trunk-2010-06`: three files that were only in my working copies.

Each Subversion revision on a branch is one commit, with its log message and a `git-svn-id:` line that gives its revision
number; the revisions that only copied a branch to a tag are not here (see the history above), nor one that only changed
the data file left out (below). Empty log messages read "(no log message)".

Left out of the whole history: a data file with user rows that hold other people's addresses, and the results of a file
timing test that other people ran and sent me. Where a client's name was left in code or in a comment, it reads
`travel-agency`; passwords read `REDACTED`.

## How it was built

From the Subversion dump of the repository (633 revisions) and four working copies, turned into git in 2026
(157 commits on `main`) with `git svn`, the dates and messages kept. Folders that Subversion emptied and filled
again became branches of their own (`main`, `1.0`); folders it renamed or deleted kept their branch
(`rudweb-reloaded`). The last commit before this README on each branch sets LF line endings and indents with spaces
(not in the third-party code).

## Third-party code

Bundled as it shipped: FCKeditor 2.6 (`rudweb/3rdparty/`, and `kit/lib/editor/` in `1.0`; GPL, LGPL or MPL), TinyMCE
3.2.5 (LGPL), jQuery 1.3.2 (MIT or GPL), Prototype and lightbox (MIT, in `1.0`), csshover, iepngfix,
DD_belatedPNG and queryLoader, CalendarPopup, and the Bitstream Vera Mono font (Bitstream Vera licence), each with its own
licence text where the package had one. `extra/docs/output/` (`5.0`) is phpDocumentor's output for my code, with its template's images; `rudweb/3rdparty/Smarty/`
holds only empty folder stubs.

## Licence

New BSD (see `LICENSE`), added in 2026; it replaces the GPL v3 text at the top of `main`. RudWEb 1 to 4 (trunk, `2.0` to
`4.0`) shipped the GPL v3, the 2008 engine in `1.0` only a placeholder line, and 5.0 the New BSD licence
(`src/LICENSE`), which this archive uses too.
