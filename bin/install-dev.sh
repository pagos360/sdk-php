#!/usr/bin/env bash

PRE_COMMIT_HOOK_PATH=${PWD}/.git/hooks/pre-commit;

if [ -f "$PRE_COMMIT_HOOK_PATH" ]; then
    rm "${PRE_COMMIT_HOOK_PATH}";
fi

ln -s "${PWD}"/bin/pre-commit-hook "${PRE_COMMIT_HOOK_PATH}";
chmod +x "${PRE_COMMIT_HOOK_PATH}";

exit 0;
